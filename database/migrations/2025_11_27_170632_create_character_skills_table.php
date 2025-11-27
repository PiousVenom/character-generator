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
        Schema::create('character_skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('character_id');
            $table->uuid('skill_id');
            $table->boolean('is_proficient')->default(false);
            $table->boolean('has_expertise')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('restrict');
            $table->unique(['character_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_skills');
    }
};
