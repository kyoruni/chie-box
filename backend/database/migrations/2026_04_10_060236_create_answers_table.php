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
        Schema::create('answers', function (Blueprint $table) {
            $table->comment('回答');
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete()->comment('対象の質問');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('回答者');
            $table->text('body')->comment('回答本文');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
