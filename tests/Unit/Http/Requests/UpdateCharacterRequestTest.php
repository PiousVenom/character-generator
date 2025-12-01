<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\UpdateCharacterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * Unit tests for UpdateCharacterRequest validation rules.
 *
 * Tests that partial updates work correctly with 'sometimes' validation.
 */
final class UpdateCharacterRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testAbilityScoreMaxStillValidated(): void
    {
        $data = [
            'abilityScores' => [
                'dexterity' => 19,
            ],
        ];

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores.dexterity', $validator->errors()->toArray());
    }

    public function testAbilityScoreMinStillValidated(): void
    {
        $data = [
            'abilityScores' => [
                'strength' => 2,
            ],
        ];

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores.strength', $validator->errors()->toArray());
    }

    // =====================================
    // Nullable Fields Tests
    // =====================================

    public function testAlignmentCanBeSetToNull(): void
    {
        $data = ['alignment' => null];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testAlignmentValidationStillApplied(): void
    {
        $data = ['alignment' => 'invalid-alignment'];

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('alignment', $validator->errors()->toArray());
    }

    public function testAllFieldsOptional(): void
    {
        // Test that each field is truly optional
        $optionalFields = [
            'name',
            'alignment',
            'personalityTraits',
            'ideals',
            'bonds',
            'flaws',
            'backstory',
            'notes',
        ];

        foreach ($optionalFields as $field) {
            $validator = $this->makeValidator([]);

            $this->assertFalse(
                $validator->fails(),
                "Validation should pass without {$field}"
            );
            $this->assertArrayNotHasKey(
                $field,
                $validator->errors()->toArray(),
                "No error should be present for missing {$field}"
            );
        }
    }

    // =====================================
    // Valid Alignment Values Tests
    // =====================================

    public function testAllValidAlignmentValuesAccepted(): void
    {
        $validAlignments = [
            'lawful_good',
            'neutral_good',
            'chaotic_good',
            'lawful_neutral',
            'true_neutral',
            'chaotic_neutral',
            'lawful_evil',
            'neutral_evil',
            'chaotic_evil',
        ];

        foreach ($validAlignments as $alignment) {
            $data = ['alignment' => $alignment];

            $validator = $this->makeValidator($data);

            $this->assertFalse($validator->fails(), "Alignment '{$alignment}' should be valid");
        }
    }

    // =====================================
    // Authorization Tests
    // =====================================

    public function testAuthorizeReturnsTrue(): void
    {
        $request = new UpdateCharacterRequest();

        $this->assertTrue($request->authorize());
    }

    public function testBackstoryCanBeSetToNull(): void
    {
        $data = ['backstory' => null];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testBackstoryMaxLengthStillValidated(): void
    {
        $data = ['backstory' => str_repeat('a', 10001)];

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('backstory', $validator->errors()->toArray());
    }

    public function testCustomErrorMessageForAbilityScoreMin(): void
    {
        $data = [
            'abilityScores' => [
                'wisdom' => 2,
            ],
        ];

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('at least 3', $errors['abilityScores.wisdom'][0]);
    }

    public function testCustomErrorMessageForInvalidAlignment(): void
    {
        $data = ['alignment' => 'bad'];

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('Invalid alignment', $errors['alignment'][0]);
    }

    // =====================================
    // Custom Error Message Tests
    // =====================================

    public function testCustomErrorMessageForNameMaxLength(): void
    {
        $data = ['name' => str_repeat('a', 256)];

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('cannot exceed 255 characters', $errors['name'][0]);
    }

    // =====================================
    // Partial Update Tests
    // =====================================

    public function testEmptyDataPasses(): void
    {
        $validator = $this->makeValidator([]);

        $this->assertFalse($validator->fails());
    }

    public function testMultipleAbilityScoresCanBeUpdated(): void
    {
        $data = [
            'abilityScores' => [
                'strength'     => 16,
                'constitution' => 14,
            ],
        ];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    // =====================================
    // Multiple Fields Update Tests
    // =====================================

    public function testMultipleFieldsCanBeUpdated(): void
    {
        $data = [
            'name'      => 'Updated Name',
            'alignment' => 'lawful_evil',
            'backstory' => 'A dark past...',
        ];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    // =====================================
    // Validation Rules Still Apply Tests
    // =====================================

    public function testNameMaxLengthStillValidated(): void
    {
        $data = ['name' => str_repeat('a', 256)];

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function testNotesCanBeSetToNull(): void
    {
        $data = ['notes' => null];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testNotesMaxLengthValidated(): void
    {
        $data = ['notes' => str_repeat('a', 10001)];

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('notes', $validator->errors()->toArray());
    }

    public function testPartialUpdateWithOnlyAlignmentPasses(): void
    {
        $data = ['alignment' => 'chaotic_neutral'];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testPartialUpdateWithOnlyBackstoryPasses(): void
    {
        $data = ['backstory' => 'A long and winding tale of adventure...'];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testPartialUpdateWithOnlyNamePasses(): void
    {
        $data = ['name' => 'New Name'];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testPartialUpdateWithSingleAbilityScorePasses(): void
    {
        $data = [
            'abilityScores' => [
                'strength' => 16,
            ],
        ];

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    /**
     * Create a validator for the given data using UpdateCharacterRequest rules.
     *
     * @param array<string, mixed> $data
     */
    private function makeValidator(array $data): \Illuminate\Validation\Validator
    {
        $request = new UpdateCharacterRequest();

        return Validator::make(
            $data,
            $request->rules(),
            $request->messages(),
            $request->attributes()
        );
    }
}
