<?php

declare(strict_types=1);

namespace Tests\Feature\Exceptions;

use App\Http\Middleware\CorrelationId;
use App\Models\ErrorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class ExceptionHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test404ErrorsHandledCorrectly(): void
    {
        $response = $this->getJson('/api/v1/test/not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test500ErrorsHandledCorrectly(): void
    {
        $response = $this->getJson('/api/v1/test/server-error');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function testCorrelationIdAppearsInErrorResponseHeader(): void
    {
        $correlationId = Str::uuid()->toString();

        $response = $this->getJson('/api/v1/test/exception', [
            CorrelationId::HEADER_NAME => $correlationId,
        ]);

        $response->assertHeader(CorrelationId::HEADER_NAME, $correlationId);
    }

    public function testDifferentExceptionTypesLoggedCorrectly(): void
    {
        $this->getJson('/api/v1/test/exception');
        $this->getJson('/api/v1/test/not-found');

        $logs = ErrorLog::all();

        $this->assertGreaterThanOrEqual(1, $logs->count());
    }

    public function testErrorLogContainsCorrelationId(): void
    {
        $correlationId = Str::uuid()->toString();

        $this->getJson('/api/v1/test/exception', [
            CorrelationId::HEADER_NAME => $correlationId,
        ]);

        $this->assertDatabaseHas('error_logs', [
            'correlation_id' => $correlationId,
        ]);
    }

    public function testErrorLogContainsExceptionDetails(): void
    {
        $this->getJson('/api/v1/test/exception');

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertSame('RuntimeException', $log->exception_class);
        $this->assertSame('Test exception message', $log->exception_message);
        $this->assertNotNull($log->exception_file);
        $this->assertNotNull($log->exception_line);
    }

    public function testErrorLogContainsRequestContext(): void
    {
        $this->getJson('/api/v1/test/exception', [
            'User-Agent' => 'TestBrowser/1.0',
        ]);

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->url);
        $this->assertStringContainsString('/api/v1/test/exception', $log->url);
        $this->assertNotNull($log->method);
        $this->assertSame('GET', $log->method);
        $this->assertNotNull($log->user_agent);
        $this->assertNotNull($log->ip_address);
    }

    public function testErrorLogContextContainsRequestId(): void
    {
        $correlationId = Str::uuid()->toString();

        $this->getJson('/api/v1/test/exception', [
            CorrelationId::HEADER_NAME => $correlationId,
        ]);

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertIsArray($log->context);
        $this->assertArrayHasKey('request_id', $log->context);
        $this->assertSame($correlationId, $log->context['request_id']);
    }

    public function testErrorLogHasOccurredAtTimestamp(): void
    {
        $before = now()->subSecond();

        $this->getJson('/api/v1/test/exception');

        $after = now()->addSecond();

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->occurred_at);
        $this->assertTrue(
            $log->occurred_at->between($before, $after),
            'occurred_at should be between test start and end times',
        );
    }

    public function testErrorLogHasUuidPrimaryKey(): void
    {
        $this->getJson('/api/v1/test/exception');

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertTrue(Str::isUuid($log->id));
    }

    public function testExceptionsAreLoggedToErrorLogsTable(): void
    {
        $this->assertDatabaseCount('error_logs', 0);

        $this->withoutExceptionHandling([RuntimeException::class]);

        try {
            $this->getJson('/api/v1/test/exception');
        } catch (RuntimeException) {
            // Expected
        }

        // Re-enable exception handling and make a real request
        $this->withExceptionHandling();
        $this->getJson('/api/v1/test/exception');

        $this->assertDatabaseHas('error_logs', [
            'level' => 'error',
        ]);
    }

    public function testExceptionTraceExcludedWhenDebugDisabled(): void
    {
        config(['app.debug' => false]);

        $this->getJson('/api/v1/test/exception');

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertNull($log->exception_trace);
    }

    public function testExceptionTraceIncludedWhenDebugEnabled(): void
    {
        config(['app.debug' => true]);

        $this->getJson('/api/v1/test/exception');

        $log = ErrorLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->exception_trace);
        $this->assertStringContainsString('ExceptionHandlerTest', $log->exception_trace);
    }

    public function testMultipleExceptionsCreateMultipleLogs(): void
    {
        $this->getJson('/api/v1/test/exception');
        $this->getJson('/api/v1/test/exception');

        $this->assertDatabaseCount('error_logs', 2);
    }

    public function testValidationErrorsHandledCorrectly(): void
    {
        $response = $this->getJson('/api/v1/test/validation-error');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Register test routes that throw various exceptions
        Route::middleware(['api'])->prefix('api/v1/test')->group(static function (): void {
            Route::get('/exception', static function (): never {
                throw new RuntimeException('Test exception message', 500);
            });

            Route::get('/not-found', static function (): never {
                abort(404, 'Resource not found');
            });

            Route::get('/validation-error', static function (): never {
                throw new ValidationException(
                    Validator::make(
                        ['name' => ''],
                        ['name' => 'required'],
                    ),
                );
            });

            Route::get('/server-error', static function (): never {
                abort(500, 'Internal server error');
            });
        });
    }
}
