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
        Schema::create('game_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->integer('score');
            $table->integer('total_points')->default(0)->comment('Total points earned');
            $table->integer('max_possible_points')->default(0)->comment('Maximum possible points');
            $table->integer('correct_answers')->default(0)->comment('Number of correct answers');
            $table->integer('incorrect_answers')->default(0)->comment('Number of incorrect answers');
            $table->integer('time_taken')->nullable()->comment('Total time taken in seconds');
            $table->decimal('accuracy_percentage', 5, 2)->default(0)->comment('Accuracy percentage');
            $table->integer('attempt_number')->default(1)->comment('Attempt number for this user and game');
            $table->string('certificate_id')->nullable()->comment('Unique certificate identifier');
            $table->timestamp('certificate_generated_at')->nullable()->comment('When certificate was generated');
            $table->json('question_details')->nullable()->comment('Detailed question-by-question breakdown');
            $table->json('performance_metrics')->nullable()->comment('Additional performance metrics');
            $table->string('device_info')->nullable()->comment('Device/browser information');
            $table->string('ip_address')->nullable()->comment('IP address for analytics');
            $table->integer('total_questions');
            $table->json('answers')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_results');
    }
};
