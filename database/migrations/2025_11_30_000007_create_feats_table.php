<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('feats');
    }

    public function up(): void
    {
        Schema::create('feats', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->string('category', 30);
            $table->unsignedTinyInteger('level_requirement')->nullable();
            $table->json('prerequisites')->nullable();
            $table->json('benefits');
            $table->json('ability_score_increase')->nullable();
            $table->boolean('repeatable')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('level_requirement');
        });
    }
};
