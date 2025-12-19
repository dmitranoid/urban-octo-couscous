<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\Product;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;
use ZipArchive;

class ImportImagesService
{
    /** * @var string relative path in laravel "storage" folder */
    private string $srcFolder;

    /** @var string relative path in laravel "storage" folder */
    private string $publicFolder;

    private bool $clearSrcFolderAfterImport;

    private array $allowedImageTypes = [
        'png',
        'jpg',
        'jpeg',
        'pdf',
    ];

    private Filesystem $fs;

    private TaskProcessor $taskProcessor;

    /**
     * @param string $srcFolder relative path in laravel "storage" folder
     * @param string $publicFolder relative path in laravel "storage" folder
     */
    public function __construct(string $srcFolder = 'app/tmp/uploads/images', string $publicFolder = 'app/public/products/', $clearSrcFolderAfterImport = true)
    {
        $this->fs = new Filesystem();
        logger()->info('ensureDirectoryExists - ' . storage_path($publicFolder));
        $this->fs->ensureDirectoryExists(storage_path($publicFolder));
        $this->srcFolder = $srcFolder;
        $this->publicFolder = $publicFolder;
        $this->clearSrcFolderAfterImport = $clearSrcFolderAfterImport;
    }

    public function setTaskProcessor(TaskProcessor $taskProcessor):void
    {
        $this->taskProcessor = $taskProcessor;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $this->taskProcessor->changeStatus('started');

        if (!$this->fs->exists(storage_path($this->srcFolder))) {
            throw new Exception('Images import source folder not exists. ' . storage_path($this->srcFolder));
        }

        $files = $this->fs->allFiles(storage_path($this->srcFolder));

        $this->taskProcessor->logger()->info('files found:' . count($files));

        $products = $this->getProductsNoProcessedImages();
        foreach ($files as $file) {
            /** @var Product $product */
            $product = $products->firstWhere(fn($item) => $item->image === $file->getBasename());
            if (!$product) {
                $this->taskProcessor->logger()->warning('no product for file ' . $file->getFilename());
                $this->fs->delete($file->getRealPath());
                continue;
            }

            if (!$this->isAllowedFile($file)) {
                $this->taskProcessor->logger()->warning('file type ' . $file->getFileName() . ' not allowed');
                continue;
            }

             $publicFilePath = $this->generatePublicImagePathForProduct($product);
            $this->fs->ensureDirectoryExists($publicFilePath);
            try {
                $this->fs->move($file->getRealPath(), $publicFilePath . $file->getBasename());
            } catch (Exception $e) {
                $this->taskProcessor->logger()->error('error move file ' . $file->getRealPath() . ' to ' . $publicFilePath . ' (' . $e->getMessage() . ')');
                continue;
            }

            switch ($this->getFileTypeByExtension($file->getExtension())) {
                case 'image':
                    if (!$this->updateProductImage($product->id, realpath($publicFilePath . $file->getBasename()))) {
                        $this->taskProcessor->logger()->error('error updating product image product_id=' . $product->id);
                    } else {
                        $this->taskProcessor->logger()->info('updating product image product_id=' . $product->id . ' success');
                    }
                    break;
                case 'document':
                    if (!$this->updateProductDocument($product->id, realpath($publicFilePath . $file->getBasename()))) {
                        $this->taskProcessor->logger()->error('error updating product document product_id=' . $product->id);
                    } else {
                        $this->taskProcessor->logger()->info('updating product document product_id=' . $product->id . ' success');
                    }
                    break;
                default:
                    $this->taskProcessor->logger()->error('error, you will never get in here' . $file->getRealPath() );
            }
        }

        if ($this->clearSrcFolderAfterImport) {
            $this->taskProcessor->changeStatus('clear old data');
            $this->clearFolder(storage_path($this->srcFolder));
        }
        $this->taskProcessor->changeStatus('finished');
    }

    private function generateFileUrl(string $filename): string
    {
        $filename = Str::remove(storage_path('/app/public'), $filename, false);
        return Storage::url($filename);
    }

    private function updateProductImage(int $productId, string $newImageFile): bool
    {
        /** @var Product $product */
        $product = Product::find($productId);
        if (!$product) {
            return false;
        }
        return $product->update(['image' => $this->generateFileUrl($newImageFile)]);
    }

    private function updateProductDocument(int $productId, string $newDocumentFile): bool
    {
        /** @var Product $product */
        $product = Product::find($productId);
        if (!$product) {
            return false;
        }
        return $product->update(['files' => [$this->generateFileUrl($newDocumentFile)]]);
    }

    private function isAllowedFile(SplFileInfo $fileInfo): bool
    {
        return in_array(strtolower($fileInfo->getExtension()), $this->allowedImageTypes);
    }

    private function getFileTypeByExtension(string $extension): string
    {
        return match (strtolower($extension)) {
            'jpg', 'jpeg', 'png' => 'image',
            'pdf' => 'document',
            default => ''
        };
    }

    private function generatePublicImagePathForProduct(Product $product): string
    {
        // public/manufacturer/category
        return str_replace('//', '/', implode(DIRECTORY_SEPARATOR, [
                storage_path($this->publicFolder),
                $product->manufacturer_slug ?? 'unknown_manufacturer',
                $product->category_slug ?? 'unknown_category',
            ]) . DIRECTORY_SEPARATOR);
    }

    /**
     * products list for update images
     */
    private function getProductsNoProcessedImages(): Collection
    {
        return Product::where('products.image', 'not like', '%/%')
            ->whereNotNull('products.image')
            ->join('manufacturers', 'manufacturers.id', 'manufacturer_id')
            ->join('categories', 'categories.id', 'category_id')
            ->where('products.image', '<>', '')
            ->select(['products.id', 'products.image', 'manufacturers.slug as manufacturer_slug', 'categories.slug as category_slug'])
            ->get();
    }

    private function getProductsNoProcessedDocs(): Collection
    {
        return DB::table('attachments')
            ->join('attachmentable', 'attachments.id', 'attachment_id')
            ->join('products', 'attachmentable_id', 'products.id')
            ->where('attachments.path', '')
            ->orWhereNull('attachments.path')
            ->select('products.id', 'attachments.*')
            ->get();
    }

    private function clearFolder($path): bool
    {
        $this->taskProcessor->logger()->info('Clean Directory ' . $path);
        return $this->fs->cleanDirectory($path);
    }

    public function unzip(string $zipFilename, string $toFolder = null, bool $removeZip = true): bool
    {
        $this->taskProcessor->changeStatus('unzip');
        $toFolder = $toFolder ?? storage_path($this->srcFolder);
        $zip = new ZipArchive();
        if (true !== ($err = $zip->open($zipFilename))) {
            $this->taskProcessor->logger()->error('archive process error:' . $err);
            $this->taskProcessor->changeStatus('error', 'zip process error');
            return false;
        }
        try {
            if (!$result = $zip->extractTo($toFolder)) {
                $this->taskProcessor->logger()->error('Unzip file ' . $zipFilename . ' to ' . $toFolder . ' error');
            } else {
                $this->taskProcessor->logger()->info('Unzip file ' . $zipFilename . ' to ' . $toFolder . ' success');
            }
            $zip->close();
        } catch (Exception $e) {
            $this->taskProcessor->logger()->error('archive process error:' . $e->getMessage());
            $this->taskProcessor->changeStatus('error', 'zip process error');
            return false;
        }
        if ($removeZip) {
            $this->fs->delete($zipFilename);
            $this->taskProcessor->logger()->info('Remove archive file ' . $zipFilename);
        }

        return $result;
    }
}