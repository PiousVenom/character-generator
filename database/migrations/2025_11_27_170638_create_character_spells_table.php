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
        Schema::create('character_spells', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('character_id');
            $table->uuid('spell_id');
            $table->boolean('is_prepared')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('spell_id')->references('id')->on('spells')->onDelete('restrict');
            $table->unique(['character_id', 'spell_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_spells');
    }
};
