<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

use function count;

/**
 * Feature tests for validation error response format.
 */
final class ValidationErrorResponseTest extends TestCase
{
    use RefreshDatabase;

    // =====================================
    // camelCase Input Accepted Tests
    // =====================================

    public function testCamelCaseFieldNamesAccepted(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test Character',
            'classId'       => $class->id,       // camelCase
            'speciesId'     => $species->id,     // camelCase
            'backgroundId'  => $background->id,  // camelCase
            'abilityScores' => [                  // camelCase
                'strength'     => 15,
                'dexterity'    => 14,
                'constitution' => 13,
                'intelligence' => 12,
                'wisdom'       => 10,
                'charisma'     => 8,
            ],
        ]);

        $response->assertCreated();
    }

    public function testCustomErrorMessageForAbilityScoreTooHigh(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 19, // Too high
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $errors = $response->json('errors');

        $this->assertIsArray($errors);
        $this->assertArrayHasKey('abilityScores.strength', $errors);
        /** @var array<int, string> $errorMessages */
        $errorMessages = $errors['abilityScores.strength'];
        $this->assertIsArray($errorMessages);
        $this->assertStringContainsString('cannot exceed 18', $errorMessages[0]);
    }

    public function testCustomErrorMessageForAbilityScoreTooLow(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 2, // Too low
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $errors = $response->json('errors');

        $this->assertIsArray($errors);
        $this->assertArrayHasKey('abilityScores.strength', $errors);
        /** @var array<int, string> $errorMessages */
        $errorMessages = $errors['abilityScores.strength'];
        $this->assertIsArray($errorMessages);
        $this->assertStringContainsString('at least 3', $errorMessages[0]);
    }

    public function testCustomErrorMessageForInvalidAlignment(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'alignment'     => 'invalid-alignment',
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $errors = $response->json('errors.alignment');

        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
        $this->assertIsString($errors[0]);
        $this->assertStringContainsString('Invalid alignment', $errors[0]);
    }

    public function testCustomErrorMessageForInvalidClassId(): void
    {
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => 'not-a-uuid',
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $errors = $response->json('errors.classId');

        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
        $this->assertIsString($errors[0]);
        $this->assertStringContainsString('Invalid class ID format', $errors[0]);
    }

    // =====================================
    // Custom Error Message Tests
    // =====================================

    public function testCustomErrorMessageForMissingName(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $errors = $response->json('errors.name');

        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
        $this->assertIsString($errors[0]);
        $this->assertStringContainsString('Character name is required', $errors[0]);
    }

    public function testCustomErrorMessageForNonExistentClassId(): void
    {
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => Str::uuid()->toString(),
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $errors = $response->json('errors.classId');

        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
        $this->assertIsString($errors[0]);
        $this->assertStringContainsString('does not exist', $errors[0]);
    }

    public function testMultipleValidationErrorsReturnedAtOnce(): void
    {
        // Send empty request - should fail on multiple required fields
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $errors = $response->json('errors');

        $this->assertIsArray($errors);
        // Should have errors for name, classId, speciesId, backgroundId, abilityScores
        $this->assertGreaterThanOrEqual(5, count($errors));
    }

    public function testOptionalCamelCaseFieldsAccepted(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'              => 'Test Character',
            'classId'           => $class->id,
            'speciesId'         => $species->id,
            'backgroundId'      => $background->id,
            'personalityTraits' => 'Brave', // camelCase
            'abilityScores'     => [
                'strength'     => 15,
                'dexterity'    => 14,
                'constitution' => 13,
                'intelligence' => 12,
                'wisdom'       => 10,
                'charisma'     => 8,
            ],
        ]);

        $response->assertCreated();
    }

    public function testUpdateValidationErrorIncludesMessage(): void
    {
        $character = Character::factory()->create();

        $response = $this->patchJson("/api/v1/characters/{$character->id}", [
            'alignment' => 'invalid',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonStructure(['message', 'errors']);
    }

    // =====================================
    // Update Endpoint Validation Tests
    // =====================================

    public function testUpdateValidationErrorReturns422(): void
    {
        $character = Character::factory()->create();

        $response = $this->patchJson("/api/v1/characters/{$character->id}", [
            'name' => str_repeat('a', 256), // Too long
        ]);

        $response->assertUnprocessable();
    }

    // =====================================
    // Correlation ID in Error Response Tests
    // =====================================

    public function testValidationErrorIncludesCorrelationIdHeader(): void
    {
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $response->assertHeader('X-Correlation-ID');
    }

    public function testValidationErrorIncludesErrorsObject(): void
    {
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $response->assertJsonStructure(['errors']);
    }

    public function testValidationErrorIncludesMessageField(): void
    {
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $response->assertJsonStructure(['message']);
    }

    public function testValidationErrorPreservesProvidedCorrelationId(): void
    {
        $correlationId = Str::uuid()->toString();

        $response = $this->withHeader('X-Correlation-ID', $correlationId)
            ->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $response->assertHeader('X-Correlation-ID', $correlationId);
    }

    // =====================================
    // Error Response Structure Tests
    // =====================================

    public function testValidationErrorReturns422(): void
    {
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $response->assertStatus(422);
    }

    public function testValidationErrorsContainFieldSpecificMessages(): void
    {
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonValidationErrors(['classId']);
        $response->assertJsonValidationErrors(['speciesId']);
        $response->assertJsonValidationErrors(['backgroundId']);
        $response->assertJsonValidationErrors(['abilityScores']);
    }
}
