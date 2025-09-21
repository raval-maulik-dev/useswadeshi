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
        Schema::table('game_options', function (Blueprint $table) {
            $table->string('option_text_hi')->nullable()->after('option_text')->comment('Option text in Hindi');
            $table->string('option_text_gu')->nullable()->after('option_text_hi')->comment('Option text in Gujarati');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_options', function (Blueprint $table) {
            $table->dropColumn(['option_text_hi', 'option_text_gu']);
        });
    }
};
