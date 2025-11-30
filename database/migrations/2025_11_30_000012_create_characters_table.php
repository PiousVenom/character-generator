<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }

    public function up(): void
    {
        Schema::create('characters', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->uuid('class_id')->nullable();
            $table->uuid('species_id')->nullable();
            $table->uuid('background_id')->nullable();
            $table->uuid('subclass_id')->nullable();
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedInteger('experience_points')->default(0);
            $table->string('alignment', 20)->nullable();
            $table->unsignedSmallInteger('max_hit_points')->nullable();
            $table->unsignedSmallInteger('current_hit_points')->nullable();
            $table->unsignedSmallInteger('temporary_hit_points')->default(0);
            $table->unsignedTinyInteger('armor_class')->nullable();
            $table->tinyInteger('initiative_bonus')->nullable();
            $table->unsignedTinyInteger('speed')->nullable();
            $table->unsignedTinyInteger('proficiency_bonus')->default(2);
            $table->boolean('inspiration')->default(false);
            $table->json('appearance')->nullable();
            $table->text('personality_traits')->nullable();
            $table->text('ideals')->nullable();
            $table->text('bonds')->nullable();
            $table->text('flaws')->nullable();
            $table->text('backstory')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('restrict');

            $table->foreign('species_id')
                ->references('id')
                ->on('species')
                ->onDelete('restrict');

            $table->foreign('background_id')
                ->references('id')
                ->on('backgrounds')
                ->onDelete('restrict');

            $table->foreign('subclass_id')
                ->references('id')
                ->on('subclasses')
                ->onDelete('set null');

            $table->index('class_id');
            $table->index('species_id');
            $table->index('background_id');
            $table->index('subclass_id');
            $table->index('level');
            $table->index('created_at');
        });
    }
};
