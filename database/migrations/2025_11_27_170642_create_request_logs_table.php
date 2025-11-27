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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('correlation_id')->unique();
            $table->string('method', 10);
            $table->string('url', 2048);
            $table->string('route_name')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('request_headers')->nullable();
            $table->json('request_body')->nullable();
            $table->unsignedSmallInteger('response_status')->nullable();
            $table->json('response_body')->nullable();
            $table->decimal('execution_time', 10, 4)->nullable();
            $table->unsignedInteger('memory_usage')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('correlation_id');
            $table->index('method');
            $table->index('response_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
