<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Traits\ApiResponses;
use OpenApi\Attributes as OA;

/**
 * Base controller for API v1 endpoints.
 *
 * All v1 API controllers extend this class to inherit
 * standardized API response formatting.
 */
#[OA\Info(
    version: '1.0.0',
    title: 'D&D 5E Character Creator API',
    description: 'RESTful API for creating and managing D&D 5th Edition (2024 ruleset) characters. Provides endpoints for character CRUD operations and reference data for classes, species, and backgrounds.',
    contact: new OA\Contact(name: 'API Support', email: 'support@example.com'),
    license: new OA\License(name: 'MIT', identifier: 'MIT'),
)]
#[OA\Server(
    url: '/api/v1',
    description: 'API v1 Server',
)]
#[OA\Tag(name: 'Health', description: 'API health check endpoints')]
#[OA\Tag(name: 'Characters', description: 'Character CRUD operations')]
#[OA\Tag(name: 'Classes', description: 'D&D class reference data (read-only)')]
#[OA\Tag(name: 'Species', description: 'D&D species reference data (read-only)')]
#[OA\Tag(name: 'Backgrounds', description: 'D&D background reference data (read-only)')]
#[OA\Schema(
    schema: 'SuccessResponse',
    required: ['success', 'data', 'message', 'meta'],
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object'),
        new OA\Property(property: 'message', type: 'string', example: 'Operation successful'),
        new OA\Property(
            property: 'meta',
            type: 'object',
            properties: [
                new OA\Property(property: 'timestamp', type: 'string', format: 'date-time'),
                new OA\Property(property: 'version', type: 'string', example: 'v1'),
            ],
        ),
    ],
)]
#[OA\Schema(
    schema: 'ErrorResponse',
    required: ['success', 'error', 'meta'],
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(
            property: 'error',
            type: 'object',
            required: ['code', 'message'],
            properties: [
                new OA\Property(property: 'code', type: 'string', example: 'VALIDATION_ERROR'),
                new OA\Property(property: 'message', type: 'string', example: 'The given data was invalid.'),
                new OA\Property(property: 'details', type: 'object'),
            ],
        ),
        new OA\Property(
            property: 'meta',
            type: 'object',
            properties: [
                new OA\Property(property: 'timestamp', type: 'string', format: 'date-time'),
                new OA\Property(property: 'correlationId', type: 'string', format: 'uuid'),
            ],
        ),
    ],
)]
#[OA\Schema(
    schema: 'PaginationMeta',
    properties: [
        new OA\Property(property: 'currentPage', type: 'integer', example: 1),
        new OA\Property(property: 'perPage', type: 'integer', example: 15),
        new OA\Property(property: 'total', type: 'integer', example: 42),
        new OA\Property(property: 'lastPage', type: 'integer', example: 3),
    ],
)]
#[OA\Get(
    path: '/health',
    summary: 'Health check',
    description: 'Returns the API health status.',
    tags: ['Health'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'API is healthy',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string', example: 'ok'),
                    new OA\Property(property: 'timestamp', type: 'string', format: 'date-time'),
                    new OA\Property(property: 'version', type: 'string', example: 'v1'),
                ],
            ),
        ),
    ],
)]
abstract class Controller extends BaseController
{
    use ApiResponses;
}
