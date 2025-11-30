<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use App\Http\Middleware\CorrelationId;
use App\Models\RequestLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class RequestLoggingTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorizationHeaderIsNotLogged(): void
    {
        $this->getJson('/api/v1', [
            'Authorization' => 'Bearer secret-token',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_headers);
        $this->assertSame('[REDACTED]', $log->request_headers['authorization']);
    }

    public function testCaseInsensitiveRedactionOfSensitiveKeys(): void
    {
        $this->postJson('/api/v1', [
            'PASSWORD' => 'secret1',
            'Token'    => 'secret2',
            'API_KEY'  => 'secret3',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_body);
        $this->assertSame('[REDACTED]', $log->request_body['PASSWORD']);
        $this->assertSame('[REDACTED]', $log->request_body['Token']);
        $this->assertSame('[REDACTED]', $log->request_body['API_KEY']);
    }

    public function testCookieHeaderIsNotLogged(): void
    {
        $this->getJson('/api/v1', [
            'Cookie' => 'session=abc123',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_headers);
        $this->assertSame('[REDACTED]', $log->request_headers['cookie']);
    }

    public function testCsrfTokenHeaderIsNotLogged(): void
    {
        $this->getJson('/api/v1', [
            'X-CSRF-Token' => 'csrf-token-value',
            'X-XSRF-Token' => 'xsrf-token-value',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_headers);
        $this->assertSame('[REDACTED]', $log->request_headers['x-csrf-token']);
        $this->assertSame('[REDACTED]', $log->request_headers['x-xsrf-token']);
    }

    public function testExecutionTimeIsRecorded(): void
    {
        $this->getJson('/api/v1');

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertGreaterThan(0, (float) $log->execution_time_ms);
    }

    public function testMemoryUsageIsRecorded(): void
    {
        $this->getJson('/api/v1');

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertIsInt($log->memory_usage_bytes);
    }

    public function testNestedSensitiveDataIsRedacted(): void
    {
        $this->postJson('/api/v1', [
            'user' => [
                'name'     => 'John',
                'password' => 'secret123',
                'details'  => [
                    'token' => 'nested-token',
                ],
            ],
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_body);
        $this->assertIsArray($log->request_body);
        $this->assertArrayHasKey('user', $log->request_body);
        $user = $log->request_body['user'];
        $this->assertIsArray($user);
        $this->assertSame('John', $user['name']);
        $this->assertSame('[REDACTED]', $user['password']);
        $this->assertIsArray($user['details']);
        $this->assertSame('[REDACTED]', $user['details']['token']);
    }

    public function testNonSensitiveHeadersAreLogged(): void
    {
        $this->getJson('/api/v1', [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_headers);
        $this->assertArrayHasKey('accept', $log->request_headers);
        $acceptHeader = $log->request_headers['accept'];
        $this->assertIsArray($acceptHeader);
        $this->assertContains('application/json', $acceptHeader);
    }

    public function testPostRequestIsLoggedCorrectly(): void
    {
        $this->postJson('/api/v1', ['name' => 'Test']);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertSame('POST', $log->method);
    }

    public function testRequestLogContainsAllRequiredFields(): void
    {
        $correlationId = Str::uuid()->toString();

        $this->getJson('/api/v1', [
            CorrelationId::HEADER_NAME => $correlationId,
            'User-Agent'               => 'TestBrowser/1.0',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertSame($correlationId, $log->correlation_id);
        $this->assertSame('GET', $log->method);
        $this->assertStringContainsString('/api/v1', $log->url);
        $this->assertNotNull($log->ip_address);
        $this->assertIsArray($log->request_headers);
        $this->assertIsInt($log->response_status);
        $this->assertNotNull($log->execution_time_ms);
        $this->assertNotNull($log->memory_usage_bytes);
    }

    public function testRequestLogHasUuidPrimaryKey(): void
    {
        $this->getJson('/api/v1');

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertTrue(Str::isUuid($log->id));
    }

    public function testRequestsAreLoggedToRequestLogsTable(): void
    {
        $this->assertDatabaseCount('request_logs', 0);

        $this->getJson('/api/v1');

        $this->assertDatabaseCount('request_logs', 1);
    }

    public function testResponseStatusIsRecorded(): void
    {
        $this->getJson('/api/v1');

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertIsInt($log->response_status);
        $this->assertGreaterThanOrEqual(100, $log->response_status);
        $this->assertLessThan(600, $log->response_status);
    }

    public function testSensitivePasswordDataIsNotLoggedInBody(): void
    {
        $this->postJson('/api/v1', [
            'username'              => 'testuser',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_body);
        $this->assertSame('testuser', $log->request_body['username']);
        $this->assertSame('[REDACTED]', $log->request_body['password']);
        $this->assertSame('[REDACTED]', $log->request_body['password_confirmation']);
    }

    public function testSensitivePaymentDataIsNotLoggedInBody(): void
    {
        $this->postJson('/api/v1', [
            'amount'      => 100,
            'credit_card' => '4111111111111111',
            'cvv'         => '123',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_body);
        $this->assertSame(100, $log->request_body['amount']);
        $this->assertSame('[REDACTED]', $log->request_body['credit_card']);
        $this->assertSame('[REDACTED]', $log->request_body['cvv']);
    }

    public function testSensitiveTokenDataIsNotLoggedInBody(): void
    {
        $this->postJson('/api/v1', [
            'name'    => 'Test',
            'token'   => 'secret-token-value',
            'api_key' => 'secret-api-key',
            'secret'  => 'my-secret',
        ]);

        $log = RequestLog::first();

        $this->assertNotNull($log);
        $this->assertNotNull($log->request_body);
        $this->assertSame('Test', $log->request_body['name']);
        $this->assertSame('[REDACTED]', $log->request_body['token']);
        $this->assertSame('[REDACTED]', $log->request_body['api_key']);
        $this->assertSame('[REDACTED]', $log->request_body['secret']);
    }
}
