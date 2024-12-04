<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean("tfa")->default(false)->comment("Согласие от пользователя на 2FA");
            $table->string("tfa_code")->nullable()->comment("Код двухфакторки");
            $table->datetime("tfa_code_expries_at")->nullable()->comment("Срок годности кода");
            $table->string("telegram_chat_id")->nullable()->comment("Телеграмм чат id");
            $table->string("telegram_username")->nullable()->comment("Имя пользоавтеля телеграмм");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("tfa");
            $table->dropColumn("tfa_code");
            $table->dropColumn("tfa_code_expries_at");
            $table->dropColumn("telegram_chat_id");
            $table->dropColumn("telegram_username");
        });
    }
};