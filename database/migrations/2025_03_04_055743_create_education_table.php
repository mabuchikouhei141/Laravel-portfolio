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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('institution'); // 学校/機関名
            $table->string('degree')->nullable(); // 学位
            $table->string('field')->nullable(); // 専攻分野
            $table->date('start_date')->nullable(); // 開始日
            $table->date('end_date')->nullable(); // 終了日
            $table->boolean('current')->default(false); // 現在も在学中か
            $table->text('description')->nullable(); // 詳細説明
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
