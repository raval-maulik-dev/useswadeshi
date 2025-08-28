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
        Schema::create('game_result_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_result_id')->constrained('game_results')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('game_questions');
            $table->string('question_text');
            $table->unsignedInteger('points')->default(0);
            $table->boolean('is_correct')->default(false);
            $table->unsignedInteger('earned_points')->default(0);
            $table->unsignedInteger('time_taken')->default(0);
            $table->timestamps();

            $table->index(['game_result_id']);
            $table->index(['question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_result_questions');
    }
};
