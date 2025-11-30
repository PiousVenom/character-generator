<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('backgrounds');
    }

    public function up(): void
    {
        Schema::create('backgrounds', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->json('skill_proficiencies');
            $table->string('tool_proficiency', 100);
            $table->json('tool_proficiency_choices')->nullable();
            $table->json('starting_equipment');
            $table->decimal('starting_gold', 8, 2)->default(0);
            $table->uuid('origin_feat_id')->nullable();
            $table->string('feature_name', 100)->nullable();
            $table->text('feature_description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('origin_feat_id');
        });
    }
};
