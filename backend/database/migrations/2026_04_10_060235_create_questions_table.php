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
        Schema::create('questions', function (Blueprint $table) {
            $table->comment('質問');
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('質問者');
            $table->foreignId('category_id')->constrained()->comment('カテゴリー');
            $table->string('title')->comment('質問タイトル');
            $table->text('body')->comment('質問本文');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
