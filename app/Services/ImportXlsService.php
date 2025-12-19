<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Alert;

class ImportXlsService
{
    const STATUS_ERROR = 'error';
    const STATUS_INFO = 'info';
    const STATUS_BRAND_CREATED = 'brand_created';
    const STATUS_CATEGORY_CREATED = 'category_created';
    const STATUS_PRODUCT_CREATED = 'product_created';
    const STATUS_PRODUCT_UPDATED = 'product_updated';


    private Collection $dbBrands;
    private Collection $dbCategories;

    private TaskProcessor $taskProcessor;

    private $params = [
        'autocreateManufacturer' => true,
        'autopublishCreated' => true,
        'autocreateCategory' => true,
        'truncateOldData' => false,
    ];

    public function setTaskProcessor($taskProcessor)
    {
        $this->taskProcessor = $taskProcessor;
    }

    public function handle(array $data, array $params = [])
    {
        $this->params = array_merge([
            'autopublishCreated'=> false,
        ], $params );

        $this->taskProcessor->changeStatus('import');
        $this->taskProcessor->logger()->info('params', $this->params);
        $this->dbCategories = Category::with('manufacturer')->get();
        $this->dbBrands = Manufacturer::all();
        $mappedData = [];
        $this->taskProcessor->changeStatus('map xls to data');
        $this->taskProcessor->logger()->info('xls rows:' , ['count' => count($data)]);
        foreach ($data as $row) {
            if ($this->validateData($dataRow = $this->mapRow($row))) {
                $mappedData[] = $this->mapRow($row);
            };
        }
        $this->taskProcessor->logger()->info('mapped rows:' , ['count' => count($mappedData)]);
        $this->importToDB($mappedData);
        $this->taskProcessor->changeStatus('finished');
    }

    private function validateData($dataRow): bool
    {
        $result = Str::slug($dataRow['brand']) && Str::slug($dataRow['category'] && Str::slug($dataRow['name']));
        if (!$result) {
            $this->taskProcessor->logger()->error('error_validate, some data is empty', $dataRow);
        };
        return $result;
    }

    private function mapRow(array $row): array
    {
        return [
            'sku' => $row[1],
            'name' => $row[2],
            'description' => $row[6],
            'brand' => $row[9],
            'category' => $row[5],
            'price' => floatval( $row[10] ?: '0'),
            'stock' => floatval( $row[11] ?: '0'),
            'stockP' => floatval( $row[12] ?: '0'),
            'image' => $row[0],
            'pdf' => $row[23],
        ];
    }

    public function importToDB($data): bool
    {
        $stats = [
            'brands_created' => 0,
            'categories_created' => 0,
            'products_created' => 0,
            'products_updated' => 0,
        ];

        // пока ищем совпадение по slug, возмжно надо будет переделать на наименование
        $result = true;
        foreach ($data as $dataRow) {
            $brand = $this->dbBrands->firstWhere('slug', '=', \Illuminate\Support\Str::slug($dataRow['brand']));
            if (!$brand) {
                $brand = new Manufacturer([
                    'name' => $dataRow['brand'],
                    'slug' => Str::slug($dataRow['brand']),
                    'image' => null,
                    'position' => 100,
                    'is_active' => $this->params['autopublishCreated'] ? 1 : 0,
                ]);
                if (!$brand->save()) {
                    $this->taskProcessor->logger()->error(self::STATUS_ERROR . 'brand create', ['name' => $dataRow['brand']]);
                    $this->taskProcessor->logger()->info('skip product create', $dataRow);
                    $brand = null;
                    $result = false;
                    continue;
                }
                $this->taskProcessor->logger()->info(self::STATUS_BRAND_CREATED,['id' => $brand->id, 'name' => $brand->name]);
                $this->dbBrands->add($brand);
            } else {
                $this->taskProcessor->logger()->info('brand exists', ['id' => $brand->id, 'name' => $brand->name]);
            }
            $category = $this->dbCategories->filter(
                fn($item, $key) => ($item->slug === Str::slug($dataRow['category']) && ($item->manufacturer->slug === $brand->slug))
            )->first();

            if (!$category) {
                $category = new Category([
                    'manufacturer_id' => $brand->id,
                    'name' => $dataRow['category'],
                    'slug' => Str::slug($dataRow['category']),
                    'image' => null,
                    'description' => null,
                    'position' => 100,
                    'parent_id' => null,
                    'is_active' => $this->params['autopublishCreated'] ? 1 : 0,
                ]);
                if (!$category->save()) {
                    $this->taskProcessor->logger()->error(self::STATUS_ERROR . ' category create', ['name' => $dataRow['brand']]);
                    $this->taskProcessor->logger()->info('skip product create', [$dataRow]);
                    $result = false;
                    continue;
                }
                $this->taskProcessor->logger()->info(self::STATUS_CATEGORY_CREATED, ['id' => $category->id, 'name' => $category->name]);
                $category->refresh();
                $this->dbCategories->add($category);
            } else {
                $this->taskProcessor->logger()->info('category exists', ['id' => $category->id, 'name' => $category->name]);
            }

            $product = Product::where('slug', Str::slug($dataRow['sku']))->first();
            if (!$product) {
                $product = new Product([
                    'sku' => $dataRow['sku'],
                    'name' => $dataRow['name'],
                    'description' => $dataRow['description'],
                    'slug' => Str::slug($dataRow['sku']),
                    'image' => $dataRow['image'],
                    'images' => null,
                    'stock' => $dataRow['stock'],
                    'partner_stock' => $dataRow['stockP'],
                    'price' => $dataRow['price'],
                    'meta_title' => $dataRow['meta_title'] ?? '',
                    'meta_description' => $dataRow['meta_description'] ?? '',
                    'manufacturer_id' => $brand->id,
                    'category_id' => $category->id,
                    'is_active' => $this->params['autopublishCreated'] ? 1 : 0,
                ]);
                if (!$product->save()) {
                    $this->taskProcessor->logger()->error(self::STATUS_ERROR . 'product create', $dataRow);
                    $result = false;
                    continue;
                } else {
                    $this->taskProcessor->logger()->info(self::STATUS_PRODUCT_CREATED, ['id' => $product->id, 'name' => $product->name]);
                }
            } else {
                // try update price and stock
                $product->price = $dataRow['price'];
                $product->stock = $dataRow['stock'];
                $product->partner_stock = $dataRow['stockP'];
                if (!$product->save()) {
                    $this->taskProcessor->logger()->error(self::STATUS_ERROR . 'product update', $dataRow);
                    $result = false;
                    continue;
                }
                $this->taskProcessor->logger()->info(self::STATUS_PRODUCT_UPDATED, ['id' => $product->id, 'name' => $product->name]);
            }
        }
        return $result;
    }

}