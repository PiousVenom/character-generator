<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::table('backgrounds', static function (Blueprint $table): void {
            $table->dropForeign(['origin_feat_id']);
        });
    }

    public function up(): void
    {
        Schema::table('backgrounds', static function (Blueprint $table): void {
            $table->foreign('origin_feat_id')
                ->references('id')
                ->on('feats')
                ->onDelete('set null');
        });
    }
};
