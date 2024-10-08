<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageDelete implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
        Log::info('Эвент делит создается');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("Chat")
        ];
    }

    public function broadcastAs()
    {
        return 'chat.delete';
    }

    public function broadcastWith()
    {
        try {
            $data = [
                'id' => $this->message->id,
            ];

            Log::info('Эвент делит:', ['message' => $data]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Ошибка при подготовке данных для трансляции в эвенте MessageDelete:', [
                'error' => $e->getMessage()
            ]);

            // Можно также выполнить дополнительные действия, например, уведомить администратора или вызвать другой эвент
            return [];
        }
    }
}
