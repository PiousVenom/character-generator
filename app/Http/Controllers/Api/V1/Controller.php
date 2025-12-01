<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Traits\ApiResponses;

/**
 * Base controller for API v1 endpoints.
 *
 * All v1 API controllers extend this class to inherit
 * standardized API response formatting.
 */
abstract class Controller extends BaseController
{
    use ApiResponses;
}
