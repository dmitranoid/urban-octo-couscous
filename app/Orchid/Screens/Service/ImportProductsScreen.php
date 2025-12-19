<?php

namespace App\Orchid\Screens\Service;

use App\Imports\ProductsImport;
use App\Services\ImportXlsService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ImportProductsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'result' => \request()->input('result') ?? false,
            'import' => [
                'filename' => "",
                "upload_images" => 1,
                'remove_old_data' => 0,
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Import Products';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
//        return [
//            Button::make('Save')->method('saveSettings'),
//            Button::make('Start')->method('startImport'),
//        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        /*
                if ($this->query()['result'] ?? false) {
                    $messageLayout =
                       Layout::rows([
                           Label::make('test')->title('Import success'),
                       ]);
                } else {
                    $messageLayout = [];
                    Layout::rows([
                        Label::make('test')->title(''),
                    ]);
                }
        */
        return [
            Layout::rows([
                Upload::make('import.filename')
                    ->title('imported file')
                    ->help('xls or xlsx file')
                    ->maxFiles(1)
                    ->acceptedFiles('application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
//                Switcher::make('import.upload_images')
//                    ->sendTrueOrFalse()
//                    ->title('if off, images located in public foolder, else will be moved to it'),
//                Switcher::make('import.delete_old_data')
//                    ->sendTrueOrFalse()
//                    ->title('delete old data before import'),
                Button::make('Start import')
                    ->method('startImport')
                    ->style('border-width:thin; border-color:rgb(233, 236, 239);')
                    ->icon('bs.box-arrow-in-down'),
            ]),
            //$messageLayout,
        ];
    }

    public function saveSettings()
    {

    }


    public function startImport()
    {
        $data = \request()->get('import') ?? false;
        $fileId = $data['filename'][0] ?? false;
        if (!$fileId) return;

        $dbAttachments = DB::table('attachments');
        $attach = $dbAttachments->find($fileId);
        $filename = Storage::disk($attach->disk)->path($attach->path . $attach->name . '.' . $attach->extension);
        $rawData = Excel::toCollection(new ProductsImport(), $filename)->toArray();
        $importService = new ImportXlsService();
        $importService->handle($rawData[0]);
        redirect()->route('platform.import.products', ['result' => 'success']);
    }
}