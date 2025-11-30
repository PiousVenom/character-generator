<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('spells');
    }

    public function up(): void
    {
        Schema::create('spells', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->unsignedTinyInteger('level');
            $table->string('school', 20);
            $table->string('casting_time', 50);
            $table->string('range', 50);
            $table->boolean('components_verbal')->default(false);
            $table->boolean('components_somatic')->default(false);
            $table->string('components_material', 255)->nullable();
            $table->decimal('components_material_cost', 10, 2)->nullable();
            $table->boolean('components_material_consumed')->default(false);
            $table->string('duration', 50);
            $table->boolean('concentration')->default(false);
            $table->boolean('ritual')->default(false);
            $table->text('higher_levels')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('level');
            $table->index('school');
            $table->index('concentration');
            $table->index('ritual');
        });
    }
};
