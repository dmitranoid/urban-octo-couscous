<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Monolog\Handler\NullHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class TaskProcessor
{
    private int $taskId;

    private Task $task;

    private LoggerInterface $logger;

    public static function findLastTaskByName(string $name):self
    {
        $task = Task::where('name', $name)->orderBy('created_at', 'desc')->first();
        return new self($task->id);
    }

    public function __construct($taskId)
    {
        $this->task = Task::findOrFail($taskId);
        $this->logger = new Logger(
            'task_' . $this->task->id,
        );
        if ($this->task->log_file) {
            $this->logger->pushHandler(new StreamHandler($this->task->log_file));
        } else {
            $this->logger->pushHandler(new NullHandler);
        }
    }

    public static function createTask(string $name, ?array $params = null, bool $useLog = true): self
    {

        $task = new Task([
            'name' => $name,
            'status' => 'new',
            'inParams' => $params,
            'log_file' => $useLog ? storage_path('logs/task/') . 'task_' . uuid_create() : null,
        ]);
        $task->save();
        return new self($task->id);
    }

    public function changeStatus(string $newStatus, ?string $message = null): void
    {
        $this->logger->info('status changed to [' . $newStatus . '] ' . $message ?? '');
        $this->task->update([
            'status' => $newStatus,
            'message' => $message,
        ]);
    }

    public function start()
    {
        $this->changeStatus('started');
    }

    public function finish()
    {
        $this->changeStatus('finished');
    }

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getTask()
    {
        return$this->task;
    }
}