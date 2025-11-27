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
        Schema::create('character_feats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('character_id');
            $table->uuid('feat_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('feat_id')->references('id')->on('feats')->onDelete('restrict');
            $table->unique(['character_id', 'feat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_feats');
    }
};
