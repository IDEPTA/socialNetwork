<?php

namespace App\Console\Commands;

use App\Service\LogService;
use Illuminate\Console\Command;
use App\Service\RabbitMQService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogConsumer extends Command
{

    protected $signature = 'log:consume-logs';
    protected $description = 'Consume logs from RabbitMQ topic exchange';


    public function __construct(private LogService $logService)
    {
        parent::__construct();
    }

    public function handle()
    {
        echo "Начинаем слушать RabbitMQ топик\n";
        // Подключаемся к RabbitMQ
        $connection = RabbitMQService::connect();
        // Создаем канал
        $channel = $connection->channel();
        // Создаем exchange
        $channel->exchange_declare('app.topic', 'topic');
        // Создаем очередь
        $channel->queue_declare('log_queue',);
        // Создаем привязку между exchange и очередью
        $channel->queue_bind('log_queue', 'app.topic', 'logs');

        // Слушаем очередь
        $channel->basic_consume('log_queue', '', false, true, false, false, function ($msg) {
            $log = json_decode($msg->body, true);
            echo "[" . Carbon::now() . "] Получен лог:\n";
            echo json_encode($log, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
            try {
                $this->logService->create($log);
            } catch (\Exception $e) {
                echo "Ошибка при сохранении лога: " . $e->getMessage() . "\n";
            }
        });

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
