<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Models\User;

class getAdminsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:admins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Возвращает список пользователей с правами администратора';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('role_id', 1);
        })->get(['id', 'name', 'email']);
        $adminData = $admins->map(function ($admin) {
            return [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
            ];
        })->toArray();

        $this->info('Администраторы: ');
        $this->table(
            ['ID', 'Name', 'Email'],
            $adminData
        );
    }
}
