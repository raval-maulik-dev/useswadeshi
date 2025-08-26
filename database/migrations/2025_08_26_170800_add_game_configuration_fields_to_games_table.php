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
        Schema::table('games', function (Blueprint $table) {
            $table->integer('total_questions')->nullable()->after('description')->comment('Number of questions to ask per game (null = all questions)');
            $table->integer('per_question_time')->nullable()->after('total_questions')->comment('Time limit per question in seconds (null = unlimited)');
            $table->boolean('allow_replay')->default(true)->after('per_question_time')->comment('Whether users can replay this game');
            $table->boolean('show_correct_answers')->default(true)->after('allow_replay')->comment('Whether to show correct answers after quiz');
            $table->boolean('is_active')->default(true)->after('show_correct_answers')->comment('Whether the game is active and playable');
            $table->integer('max_attempts')->nullable()->after('is_active')->comment('Maximum attempts per user (null = unlimited)');
            $table->json('certificate_template')->nullable()->after('max_attempts')->comment('Certificate template configuration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn([
                'total_questions',
                'per_question_time',
                'allow_replay',
                'show_correct_answers',
                'is_active',
                'max_attempts',
                'certificate_template',
            ]);
        });
    }
};
