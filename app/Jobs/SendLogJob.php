<?php

namespace App\Jobs;

use PhpAmqpLib\Message\AMQPMessage;
use App\Services\RabbitMQ\RabbitMQService;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLogJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $message,
        protected string $level = 'info',
        protected array $context = [],
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Подключаемся к RabbitMQ
        $connection = RabbitMQService::connect();
        // Создаем канал
        $channel = $connection->channel();
        // Создание топика если не существует
        $channel->exchange_declare(
            'app.topic',
            'topic'
        );

        $body = json_encode([
            'ip-address' => request()->ip(),
            'level' => $this->level,
            'message' => $this->message,
            'context' => $this->context,
        ]);

        $msg = new AMQPMessage($body, ['content_type' => 'application/json']);
        // Отправляем сообщение в топик. app.topic - имя топика, logs - routing key
        $channel->basic_publish($msg, 'app.topic', 'logs');

        $channel->close();
        $connection->close();
    }
}
