<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_result_answers', function (Blueprint $table) {
            $table->boolean('selected')->default(false)->after('is_correct_option');
        });
    }

    public function down(): void
    {
        Schema::table('game_result_answers', function (Blueprint $table) {
            $table->dropColumn('selected');
        });
    }
};
