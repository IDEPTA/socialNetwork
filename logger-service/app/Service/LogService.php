<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LogService
{
    public function create(array $logData): void
    {
        DB::table('logs')->insert([
            'ip_address' => $logData['ip-address'],
            'level' => $logData['level'],
            'message' => $logData['message'],
            'context' => json_encode($logData['context']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
