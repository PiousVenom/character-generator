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
        Schema::create('class_features', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('class_id');
            $table->uuid('subclass_id')->nullable();
            $table->string('name');
            $table->text('description');
            $table->unsignedTinyInteger('level_required');
            $table->json('benefits')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subclass_id')->references('id')->on('subclasses')->onDelete('cascade');
            $table->index('level_required');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_features');
    }
};
