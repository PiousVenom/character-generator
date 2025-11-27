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
        Schema::create('spells', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->unsignedTinyInteger('level');
            $table->enum('school', [
                'Abjuration', 'Conjuration', 'Divination', 'Enchantment',
                'Evocation', 'Illusion', 'Necromancy', 'Transmutation',
            ]);
            $table->string('casting_time');
            $table->string('range');
            $table->json('components');
            $table->string('duration');
            $table->boolean('concentration')->default(false);
            $table->boolean('ritual')->default(false);
            $table->text('description');
            $table->text('higher_levels')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('level');
            $table->index('school');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spells');
    }
};
