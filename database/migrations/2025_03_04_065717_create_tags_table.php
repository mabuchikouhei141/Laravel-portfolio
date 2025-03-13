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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // タグ名
            $table->string('slug')->unique(); // URLスラッグ
            $table->timestamps();
        });

        // プロジェクトとタグの中間テーブル
        Schema::create('project_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // 同じプロジェクトと同じタグの組み合わせを防ぐ
            $table->unique(['project_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tag');
        Schema::dropIfExists('tags');
    }
};
