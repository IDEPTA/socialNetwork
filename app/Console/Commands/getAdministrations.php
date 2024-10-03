<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Models\User;

class getAdministrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:administrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Возвращает всех пользователей с ролями администратор или модератор';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Получаем пользователей с их ролями
        $administrations = User::with('roles')->whereHas('roles')->get(['id', 'name', 'email']);

        // Формируем массив с пользователями, их ролями и другими данными
        $administrationData = $administrations->map(function ($administration) {
            return [
                'id' => $administration->id,
                'name' => $administration->name,
                'email' => $administration->email,
                'roles' => $administration->roles->pluck('name')->implode(', '), // Получаем названия ролей
            ];
        })->toArray();

        // Выводим администраторов в виде таблицы
        $this->info('Администраторы: ');
        $this->table(
            ['ID', 'Name', 'Email', 'Roles'], // Добавляем колонку для ролей
            $administrationData
        );
    }
}
