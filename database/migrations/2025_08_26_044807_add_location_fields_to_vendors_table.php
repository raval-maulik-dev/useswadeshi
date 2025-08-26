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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('business_type')->nullable()->after('description');
            $table->foreignId('city_id')->nullable()->after('business_type')->constrained()->onDelete('set null');
            $table->string('address')->nullable()->after('city_id');
            $table->boolean('verified')->default(false)->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['business_type', 'city_id', 'address', 'verified']);
        });
    }
};
