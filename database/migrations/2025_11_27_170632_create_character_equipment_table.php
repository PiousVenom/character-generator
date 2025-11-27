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
        Schema::create('character_equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('character_id');
            $table->uuid('equipment_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->boolean('is_equipped')->default(false);
            $table->boolean('is_attuned')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('restrict');
            $table->unique(['character_id', 'equipment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_equipment');
    }
};
