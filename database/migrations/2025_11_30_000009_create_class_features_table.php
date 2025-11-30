<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('class_features');
    }

    public function up(): void
    {
        Schema::create('class_features', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('class_id');
            $table->uuid('subclass_id')->nullable();
            $table->string('name', 100);
            $table->text('description');
            $table->unsignedTinyInteger('level');
            $table->boolean('is_subclass_feature')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

            $table->foreign('subclass_id')
                ->references('id')
                ->on('subclasses')
                ->onDelete('cascade');

            $table->index('class_id');
            $table->index('subclass_id');
            $table->index('level');
            $table->index(['class_id', 'level']);
        });
    }
};
