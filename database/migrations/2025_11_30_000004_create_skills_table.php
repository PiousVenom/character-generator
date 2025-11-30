<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }

    public function up(): void
    {
        Schema::create('skills', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->text('description');
            $table->string('ability', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->index('ability');
        });
    }
};
