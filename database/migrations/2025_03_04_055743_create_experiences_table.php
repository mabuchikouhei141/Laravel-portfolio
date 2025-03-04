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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company'); // 会社名
            $table->string('position'); // 役職/職位
            $table->date('start_date')->nullable(); // 開始日
            $table->date('end_date')->nullable(); // 終了日
            $table->boolean('current')->default(false); // 現在も在職中か
            $table->text('description')->nullable(); // 仕事内容や成果
            $table->string('location')->nullable(); // 勤務地
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
