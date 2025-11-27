<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('hit_die', 3);
            $table->string('primary_ability');
            $table->json('saving_throw_proficiencies');
            $table->json('armor_proficiencies');
            $table->json('weapon_proficiencies');
            $table->json('tool_proficiencies')->nullable();
            $table->unsignedTinyInteger('skill_choices_count');
            $table->json('skill_choices_list');
            $table->string('spellcasting_ability')->nullable();
            $table->json('spell_slots_progression')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
