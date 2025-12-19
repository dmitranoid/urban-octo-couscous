<?php

namespace App\Jobs;

use App\Console\Commands\ImportImagesCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ProcessImportImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $zipFile;

    /**
     * Create a new job instance.
     */
    public function __construct(string $zipfile)
    {
        $this->zipFile = $zipfile;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('app:import-images', ['zipfile' => $this->zipFile]);
    }
}