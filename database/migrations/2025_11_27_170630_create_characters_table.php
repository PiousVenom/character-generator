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
        Schema::create('characters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('class_id');
            $table->uuid('species_id');
            $table->uuid('background_id');
            $table->uuid('subclass_id')->nullable();
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedInteger('experience_points')->default(0);
            $table->string('alignment', 2);
            $table->unsignedSmallInteger('max_hit_points');
            $table->unsignedSmallInteger('current_hit_points');
            $table->unsignedSmallInteger('temporary_hit_points')->default(0);
            $table->unsignedTinyInteger('armor_class');
            $table->tinyInteger('initiative_bonus');
            $table->unsignedTinyInteger('speed');
            $table->unsignedTinyInteger('proficiency_bonus')->default(2);
            $table->boolean('inspiration')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')->references('id')->on('classes')->onDelete('restrict');
            $table->foreign('species_id')->references('id')->on('species')->onDelete('restrict');
            $table->foreign('background_id')->references('id')->on('backgrounds')->onDelete('restrict');
            $table->foreign('subclass_id')->references('id')->on('subclasses')->onDelete('set null');

            $table->index('level');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
