<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('character_equipment');
    }

    public function up(): void
    {
        Schema::create('character_equipment', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('character_id');
            $table->uuid('equipment_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->boolean('equipped')->default(false);
            $table->boolean('attuned')->default(false);
            $table->string('notes', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->onDelete('cascade');

            $table->foreign('equipment_id')
                ->references('id')
                ->on('equipment')
                ->onDelete('restrict');

            $table->unique(['character_id', 'equipment_id']);
            $table->index('character_id');
            $table->index('equipment_id');
        });
    }
};
