<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ability_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('character_id')->unique();
            $table->unsignedTinyInteger('strength');
            $table->unsignedTinyInteger('dexterity');
            $table->unsignedTinyInteger('constitution');
            $table->unsignedTinyInteger('intelligence');
            $table->unsignedTinyInteger('wisdom');
            $table->unsignedTinyInteger('charisma');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ability_scores');
    }
};
