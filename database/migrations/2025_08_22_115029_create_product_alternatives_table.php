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
        Schema::create('product_alternatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foreign_product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('local_product_id')->constrained('products')->onDelete('cascade');
            $table->string('note', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_alternatives');
    }
};
