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
        Schema::create('game_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('game_questions')->cascadeOnDelete();
            $table->string('option_text')->nullable(); // Fallback text for display
            $table->unsignedBigInteger('optionable_id')->nullable(); // Polymorphic relation to Product, Brand, etc.
            $table->string('optionable_type')->nullable(); // Polymorphic relation to Product, Brand, etc.
            $table->boolean('is_correct')->default(false);
            $table->integer('sort_order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_options');
    }
};
