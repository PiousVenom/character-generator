<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('subclasses');
    }

    public function up(): void
    {
        Schema::create('subclasses', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('class_id');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->text('description');
            $table->string('source', 50)->default('PHB 2024');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

            $table->unique(['class_id', 'slug']);
            $table->index('class_id');
        });
    }
};
