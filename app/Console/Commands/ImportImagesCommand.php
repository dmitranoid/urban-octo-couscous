<?php

namespace App\Console\Commands;

use App\Services\ImportImagesService;
use App\Services\TaskProcessor;
use Illuminate\Console\Command;

class ImportImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-images {zipfile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected string $sourceZipFile;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->sourceZipFile = $this->argument('zipfile');

        $taskProcessor = TaskProcessor::createTask('import_images', ['filename'=>$this->sourceZipFile]);
        $importService = new ImportImagesService();
        $importService->setTaskProcessor($taskProcessor);
        if (!$importService->unzip($this->sourceZipFile)) {

            return;
        }
        $importService->handle();
    }
}