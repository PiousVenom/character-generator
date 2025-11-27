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
        Schema::create('equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('type', ['Weapon', 'Armor', 'Adventuring Gear', 'Tool', 'Mount', 'Vehicle']);
            $table->text('description')->nullable();
            $table->unsignedInteger('cost_copper');
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('properties')->nullable();
            $table->json('weapon_properties')->nullable();
            $table->json('armor_properties')->nullable();
            $table->boolean('requires_attunement')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
