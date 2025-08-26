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
        Schema::table('game_results', function (Blueprint $table) {
            $table->integer('total_points')->default(0)->after('score')->comment('Total points earned');
            $table->integer('max_possible_points')->default(0)->after('total_points')->comment('Maximum possible points');
            $table->integer('correct_answers')->default(0)->after('max_possible_points')->comment('Number of correct answers');
            $table->integer('incorrect_answers')->default(0)->after('correct_answers')->comment('Number of incorrect answers');
            $table->integer('time_taken')->nullable()->after('incorrect_answers')->comment('Total time taken in seconds');
            $table->decimal('accuracy_percentage', 5, 2)->default(0)->after('time_taken')->comment('Accuracy percentage');
            $table->integer('attempt_number')->default(1)->after('accuracy_percentage')->comment('Attempt number for this user and game');
            $table->string('certificate_id')->nullable()->after('attempt_number')->comment('Unique certificate identifier');
            $table->timestamp('certificate_generated_at')->nullable()->after('certificate_id')->comment('When certificate was generated');
            $table->json('question_details')->nullable()->after('certificate_generated_at')->comment('Detailed question-by-question breakdown');
            $table->json('performance_metrics')->nullable()->after('question_details')->comment('Additional performance metrics');
            $table->string('device_info')->nullable()->after('performance_metrics')->comment('Device/browser information');
            $table->string('ip_address')->nullable()->after('device_info')->comment('IP address for analytics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_results', function (Blueprint $table) {
            $table->dropColumn([
                'total_points',
                'max_possible_points',
                'correct_answers',
                'incorrect_answers',
                'time_taken',
                'accuracy_percentage',
                'attempt_number',
                'certificate_id',
                'certificate_generated_at',
                'question_details',
                'performance_metrics',
                'device_info',
                'ip_address',
            ]);
        });
    }
};
