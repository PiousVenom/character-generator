<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }

    public function up(): void
    {
        Schema::create('classes', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->unsignedTinyInteger('hit_die');
            $table->json('primary_abilities');
            $table->json('saving_throw_proficiencies');
            $table->json('armor_proficiencies');
            $table->json('weapon_proficiencies');
            $table->json('tool_proficiencies')->nullable();
            $table->json('skill_choices');
            $table->json('starting_equipment');
            $table->string('spellcasting_ability', 20)->nullable();
            $table->unsignedTinyInteger('subclass_level')->default(3);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
