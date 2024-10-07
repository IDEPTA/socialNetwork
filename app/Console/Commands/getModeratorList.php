<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Models\User;

class getModeratorList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:moderators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Возвращает список пользователей с ролью модератор';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moderators = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get(['id', 'name', 'email']);
        $moderatorData = $moderators->map(function ($moderator) {
            return [
                'id' => $moderator->id,
                'name' => $moderator->name,
                'email' => $moderator->email,
            ];
        })->toArray();

        $this->info('Модераторы: ');
        $this->table(
            ['ID', 'Name', 'Email'],
            $moderatorData
        );
    }
}
