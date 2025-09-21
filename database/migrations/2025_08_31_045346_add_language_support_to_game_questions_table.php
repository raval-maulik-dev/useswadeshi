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
        Schema::table('game_questions', function (Blueprint $table) {
            $table->text('question_hi')->nullable()->after('question')->comment('Question text in Hindi');
            $table->text('question_gu')->nullable()->after('question_hi')->comment('Question text in Gujarati');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_questions', function (Blueprint $table) {
            $table->dropColumn(['question_hi', 'question_gu']);
        });
    }
};
