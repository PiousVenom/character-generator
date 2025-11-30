<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('class_spells');
    }

    public function up(): void
    {
        Schema::create('class_spells', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('class_id');
            $table->uuid('spell_id');
            $table->unsignedTinyInteger('level_available');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

            $table->foreign('spell_id')
                ->references('id')
                ->on('spells')
                ->onDelete('cascade');

            $table->unique(['class_id', 'spell_id']);
            $table->index('class_id');
            $table->index('spell_id');
            $table->index('level_available');
        });
    }
};
