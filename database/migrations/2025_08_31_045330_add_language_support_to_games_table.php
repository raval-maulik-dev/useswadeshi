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
            $table->string('locale')->default('en')->after('name')->comment('Language code for this game content');
            $table->string('name_hi')->nullable()->after('name')->comment('Game name in Hindi');
            $table->text('description_hi')->nullable()->after('description')->comment('Game description in Hindi');
            $table->string('name_gu')->nullable()->after('name_hi')->comment('Game name in Gujarati');
            $table->text('description_gu')->nullable()->after('description_hi')->comment('Game description in Gujarati');

            // Add index for better performance
            $table->index(['locale', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropIndex(['locale', 'is_active']);
            $table->dropColumn(['locale', 'name_hi', 'description_hi', 'name_gu', 'description_gu']);
        });
    }
};
