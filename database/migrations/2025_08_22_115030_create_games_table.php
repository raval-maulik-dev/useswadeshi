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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('total_questions')->nullable()->comment('Number of questions to ask per game (null = all questions)');
            $table->integer('per_question_time')->nullable()->comment('Time limit per question in seconds (null = unlimited)');
            $table->boolean('allow_replay')->default(true)->comment('Whether users can replay this game');
            $table->boolean('show_correct_answers')->default(true)->comment('Whether to show correct answers after quiz');
            $table->boolean('is_active')->default(true)->comment('Whether the game is active and playable');
            $table->integer('max_attempts')->nullable()->comment('Maximum attempts per user (null = unlimited)');
            $table->json('certificate_template')->nullable()->comment('Certificate template configuration');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
