<?php

namespace App\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService
{
    public static function connect(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASS', 'guest')
        );
    }
}
