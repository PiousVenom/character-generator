<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }

    public function up(): void
    {
        Schema::create('error_logs', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('correlation_id');
            $table->string('level', 20);
            $table->text('message');
            $table->string('exception_class', 255)->nullable();
            $table->text('exception_message')->nullable();
            $table->string('exception_code', 50)->nullable();
            $table->string('exception_file', 500)->nullable();
            $table->unsignedInteger('exception_line')->nullable();
            $table->longText('exception_trace')->nullable();
            $table->json('context')->nullable();
            $table->string('url', 2048)->nullable();
            $table->string('method', 10)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->softDeletes();

            $table->index('correlation_id');
            $table->index('level');
            $table->index('exception_class');
            $table->index('occurred_at');
            $table->index(['level', 'occurred_at']);
        });
    }
};
