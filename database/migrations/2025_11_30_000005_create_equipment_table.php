<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }

    public function up(): void
    {
        Schema::create('equipment', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('equipment_type', 30);
            $table->string('equipment_subtype', 50)->nullable();
            $table->unsignedInteger('cost_cp')->default(0);
            $table->decimal('weight_lb', 6, 2)->nullable();
            $table->string('damage_dice', 20)->nullable();
            $table->string('damage_type', 20)->nullable();
            $table->json('properties')->nullable();
            $table->unsignedTinyInteger('armor_class')->nullable();
            $table->unsignedTinyInteger('armor_dex_cap')->nullable();
            $table->unsignedTinyInteger('strength_requirement')->nullable();
            $table->boolean('stealth_disadvantage')->default(false);
            $table->unsignedSmallInteger('range_normal')->nullable();
            $table->unsignedSmallInteger('range_long')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('equipment_type');
            $table->index('equipment_subtype');
        });
    }
};
