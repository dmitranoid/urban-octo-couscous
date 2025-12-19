<?php

declare(strict_types=1);

namespace App\Http\Controllers\orchid;

use App\Http\Controllers\api\Controller;
use App\Jobs\ProcessImportImages;
use App\Services\PluploadHandler;
use App\Services\TaskProcessor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\Console\Output\BufferedOutput;

class OrchidImportController extends Controller
{
    public function index(): View
    {
        return \view('platform.import.view');
    }

    public function uploadChunked()
    {
        $plupload = new PluploadHandler(array(
            'target_dir' => storage_path('app/tmp/uploads'),
            'allow_extensions' => 'zip'
        ));

        // sendCORSHeaders, sendNoCacheHeaders;
        $headers = [
            "Expires: Mon, 26 Jul 1997 05:00:00 GMT",
            "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT",
            "Cache-Control: no-store, no-cache, must-revalidate",
            "Cache-Control: post-check=0, pre-check=0", false,
            "Pragma: no-cache",
        ];

        if ($result = $plupload->handleUpload()) {
            if (!array_key_exists('chunk', $result)) {
                $filename = $result['path'];
            }
            return \response()->json([
                'OK' => 1,
                'info' => $result
            ])->withHeaders($headers);
        } else {
            return \response()->json([
                'OK' => 0,
                'error' => [
                    'code' => $plupload->getErrorCode(),
                    'message' => $plupload->getErrorMessage()
                ]
            ])->withHeaders($headers);
        }
    }

    public function uploadxls()
    {
        $plupload = new PluploadHandler(array(
            'target_dir' => storage_path('app/tmp/uploads'),
            'allow_extensions' => 'xls,xlsx'
        ));
        if ($result = $plupload->handleUpload()) {
            if (!array_key_exists('chunk', $result)) {
                //start import images task
                $filename = $result['path'];
            }
            return \response()->json([
                'OK' => 1,
                'info' => $result
            ]);
        } else {
            return \response()->json([
                'OK' => 0,
                'error' => [
                    'code' => $plupload->getErrorCode(),
                    'message' => $plupload->getErrorMessage()
                ]
            ]);
        }
    }

    public function importxls()
    {
        $filename = \request()->get('filename');
        if (!$filename) {
            return \response()->json([
                'status' => 'error',
                'message' => 'empty xls filename',
            ]);
        }

        $autopublish = \request()->get('autopublish');

        // this task is fast so run ad hoc
        $output = new BufferedOutput();
        Artisan::call('app:import-xls', [
            'xlsfile' => $filename,
            '--autopublish' => $autopublish,
        ], $output);

        $task = TaskProcessor::findLastTaskByName('import_xls');
        Session::put('import_xls_task_id', $task->getTask()->id);
        return \response()->json([
            'status' => 'ok',
            'task_id' => $task->getTask()->id,
            'task_status' => $task->getTask()->status,
            'task_message' => $task->getTask()->message,
        ]);
    }

    public function importxlsStatus()
    {
        $taskId = Session::get('import_xls_task_id');
        // $taskId = request()->get('task_id');
        try {
            $task = new TaskProcessor($taskId);
        } catch (\Exception $e) {
            return \response()->json([
                'status' => 'error',
                'message' => 'task ' . $taskId . ' not found',
            ]);
        };
        return \response()->json([
            'status' => 'ok',
            'task_id' => $task->getTask()->id,
            'task_status' => $task->getTask()->status,
            'task_message' => $task->getTask()->message,
        ]);
    }

    public function importzip()
    {
        $filename = \request()->get('filename');
        if (!$filename) {
            return \response()->json([
                'status' => 'error',
                'message' => 'empty zip filename',
            ]);
        }

        // task is heavy, run through jobs
        ProcessImportImages::dispatch($filename);

        $task = TaskProcessor::findLastTaskByName('import_images');
        return \response()->json([
            'status' => 'ok',
            'task_id' => $task->getTask()->id,
            'task_status' => $task->getTask()->status,
            'task_message' => $task->getTask()->message,
        ]);
    }

    public function importzipStatus()
    {
        $taskId = \request()->get('task_id');
        $task = new TaskProcessor($taskId);
        return \response()->json([
            'status' => 'ok',
            'task_id' => $task->getTask()->id,
            'task_status' => $task->getTask()->status,
            'task_message' => $task->getTask()->message,
        ]);
    }

    public function taskStatus(int $id)
    {
        $taskId = request()->get('task_id');
        $task = new TaskProcessor($taskId);
        return \response()->json([
            'status' => 'ok',
            'task_id' => $task->getTask()->id,
            'task_status' => $task->getTask()->status,
            'task_message' => $task->getTask()->message,
            'log_url' => route('platform.task.log', ['id'=>$task->getTask()->id])
        ]);
    }
    public function taskLog(int $id)
    {
        $task = new TaskProcessor($id);
        if (!file_exists($task->getTask()->log_file)) {
            \response()->json(['status' => 'error', 'message'=>'log file not found'], 404);
        }
        return \response()->download($task->getTask()->log_file);
    }

}