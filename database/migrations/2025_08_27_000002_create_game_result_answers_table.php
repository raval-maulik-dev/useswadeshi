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
        Schema::create('game_result_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_result_question_id')->constrained('game_result_questions')->cascadeOnDelete();
            $table->foreignId('option_id')->constrained('game_options');
            $table->string('option_text');
            $table->boolean('is_correct_option')->default(false);
            $table->boolean('selected')->default(false);
            $table->timestamps();

            $table->index(['game_result_question_id']);
            $table->index(['option_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_result_answers');
    }
};
