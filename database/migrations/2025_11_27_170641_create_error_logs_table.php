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
        Schema::create('error_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('correlation_id');
            $table->string('exception_class');
            $table->text('message');
            $table->string('code', 50)->nullable();
            $table->string('file', 500)->nullable();
            $table->unsignedInteger('line')->nullable();
            $table->longText('trace')->nullable();
            $table->enum('severity', [
                'emergency', 'alert', 'critical', 'error',
                'warning', 'notice', 'info', 'debug',
            ]);
            $table->json('context')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->softDeletes();

            $table->index('correlation_id');
            $table->index('occurred_at');
            $table->index('exception_class');
            $table->index('severity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
