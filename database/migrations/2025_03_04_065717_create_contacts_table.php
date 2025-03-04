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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 名前
            $table->string('email'); // メールアドレス
            $table->string('subject')->nullable(); // 件名
            $table->text('message'); // メッセージ内容
            $table->boolean('read')->default(false); // 既読フラグ
            $table->timestamp('read_at')->nullable(); // 既読日時
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
