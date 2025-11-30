<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string                          $id
 * @property string                          $correlation_id
 * @property string                          $level
 * @property string                          $message
 * @property string|null                     $exception_class
 * @property string|null                     $exception_message
 * @property string|null                     $exception_code
 * @property string|null                     $exception_file
 * @property int|null                        $exception_line
 * @property string|null                     $exception_trace
 * @property array<string, mixed>|null       $context
 * @property string|null                     $url
 * @property string|null                     $method
 * @property string|null                     $user_agent
 * @property string|null                     $ip_address
 * @property \Illuminate\Support\Carbon      $occurred_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
final class ErrorLog extends Model
{
    use HasUuids;

    public $incrementing = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'correlation_id',
        'level',
        'message',
        'exception_class',
        'exception_message',
        'exception_code',
        'exception_file',
        'exception_line',
        'exception_trace',
        'context',
        'url',
        'method',
        'user_agent',
        'ip_address',
        'occurred_at',
    ];

    protected $keyType = 'string';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'exception_line' => 'integer',
            'context'        => 'array',
            'occurred_at'    => 'datetime',
        ];
    }
}
