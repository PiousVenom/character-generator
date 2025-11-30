<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('species');
    }

    public function up(): void
    {
        Schema::create('species', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->string('size', 20);
            $table->unsignedTinyInteger('speed')->default(30);
            $table->string('creature_type', 50)->default('Humanoid');
            $table->unsignedTinyInteger('darkvision')->nullable();
            $table->json('traits');
            $table->json('languages');
            $table->json('ability_score_options')->nullable();
            $table->boolean('has_lineage_choice')->default(false);
            $table->json('lineages')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
