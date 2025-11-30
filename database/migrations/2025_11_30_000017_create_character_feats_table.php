<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('character_feats');
    }

    public function up(): void
    {
        Schema::create('character_feats', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('character_id');
            $table->uuid('feat_id');
            $table->string('source', 50)->nullable();
            $table->json('choices')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->onDelete('cascade');

            $table->foreign('feat_id')
                ->references('id')
                ->on('feats')
                ->onDelete('restrict');

            $table->index('character_id');
            $table->index('feat_id');
        });
    }
};
