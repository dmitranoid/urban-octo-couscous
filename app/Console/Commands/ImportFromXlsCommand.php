<?php

namespace App\Console\Commands;

use App\Imports\ProductsImport;
use App\Services\ImportXlsService;
use App\Services\TaskProcessor;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportFromXlsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-xls {xlsfile} {--autopublish}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Products from Xls File';

    private string $xlsFilename;

    public function __construct(string $xlsFilename = '')
    {
        parent::__construct();
        $this->xlsFilename = $xlsFilename;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task = TaskProcessor::createTask('import_xls');
        $autopublish = (bool)$this->option('autopublish');

        $task->changeStatus('open xls',  'get data from xls');
        $this->xlsFilename = $this->argument('xlsfile');
        $rawData = Excel::toCollection(new ProductsImport(), $this->xlsFilename)->toArray();
        $importService = new ImportXlsService();
        $importService->setTaskProcessor($task);
        $importService->handle($rawData[0], ['autopublishCreated' => $autopublish]);
        $task->changeStatus('finished');
    }
}