<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\StoreCharacterRequest;
use App\Models\Background;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Unit tests for StoreCharacterRequest validation rules.
 */
final class StoreCharacterRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array<string, mixed>
     */
    private array $validData = [];

    // =====================================
    // Optional Field Validation Tests
    // =====================================

    public function testAlignmentAcceptsValidValues(): void
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
            $data              = $this->validData;
            $data['alignment'] = $alignment;

            $validator = $this->makeValidator($data);

            $this->assertFalse($validator->fails(), "Alignment '{$alignment}' should be valid");
        }
    }

    public function testAlignmentIsNullable(): void
    {
        $data              = $this->validData;
        $data['alignment'] = null;

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testAlignmentRejectsInvalidValues(): void
    {
        $data              = $this->validData;
        $data['alignment'] = 'invalid-alignment';

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('alignment', $validator->errors()->toArray());
    }

    public function testAllAbilityScoresValidated(): void
    {
        $abilities = ['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'];

        foreach ($abilities as $ability) {
            $data = $this->validData;
            /** @var array<string, int> $abilityScores */
            $abilityScores           = $data['abilityScores'];
            $abilityScores[$ability] = 0; // Invalid
            $data['abilityScores']   = $abilityScores;

            $validator = $this->makeValidator($data);

            $this->assertTrue($validator->fails(), "Validation should fail for invalid {$ability}");
            $this->assertArrayHasKey(
                "abilityScores.{$ability}",
                $validator->errors()->toArray(),
                "Error should be reported for {$ability}"
            );
        }
    }

    // =====================================
    // Authorization Tests
    // =====================================

    public function testAuthorizeReturnsTrue(): void
    {
        $request = new StoreCharacterRequest();

        $this->assertTrue($request->authorize());
    }

    public function testBackstoryAcceptsLongText(): void
    {
        $data              = $this->validData;
        $data['backstory'] = str_repeat('a', 10000);

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testBackstoryRejectsExcessivelyLongText(): void
    {
        $data              = $this->validData;
        $data['backstory'] = str_repeat('a', 10001);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('backstory', $validator->errors()->toArray());
    }

    public function testCustomErrorMessageForAbilityScoreMax(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 19;
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('cannot exceed 18', $errors['abilityScores.strength'][0]);
    }

    public function testCustomErrorMessageForAbilityScoreMin(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 2;
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('at least 3', $errors['abilityScores.strength'][0]);
    }

    public function testCustomErrorMessageForInvalidClassId(): void
    {
        $data            = $this->validData;
        $data['classId'] = 'not-a-uuid';

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('Invalid class ID format', $errors['classId'][0]);
    }

    // =====================================
    // Custom Error Message Tests
    // =====================================

    public function testCustomErrorMessageForMissingName(): void
    {
        $data = $this->validData;
        unset($data['name']);

        $validator = $this->makeValidator($data);
        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        $this->assertStringContainsString('Character name is required', $errors['name'][0]);
    }

    public function testInvalidUuidFormatForBackgroundIdReturnsError(): void
    {
        $data                   = $this->validData;
        $data['backgroundId']   = 'not-a-uuid';

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('backgroundId', $validator->errors()->toArray());
    }

    // =====================================
    // UUID Validation Tests
    // =====================================

    public function testInvalidUuidFormatForClassIdReturnsError(): void
    {
        $data              = $this->validData;
        $data['classId']   = 'not-a-uuid';

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('classId', $validator->errors()->toArray());
    }

    public function testInvalidUuidFormatForSpeciesIdReturnsError(): void
    {
        $data                = $this->validData;
        $data['speciesId']   = 'not-a-uuid';

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('speciesId', $validator->errors()->toArray());
    }

    public function testMissingAbilityScoresReturnsError(): void
    {
        $data = $this->validData;
        unset($data['abilityScores']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores', $validator->errors()->toArray());
    }

    public function testMissingBackgroundIdReturnsError(): void
    {
        $data = $this->validData;
        unset($data['backgroundId']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('backgroundId', $validator->errors()->toArray());
    }

    public function testMissingClassIdReturnsError(): void
    {
        $data = $this->validData;
        unset($data['classId']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('classId', $validator->errors()->toArray());
    }

    public function testMissingIndividualAbilityScoreReturnsError(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores = $data['abilityScores'];
        unset($abilityScores['wisdom']);
        $data['abilityScores'] = $abilityScores;

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores.wisdom', $validator->errors()->toArray());
    }

    // =====================================
    // Required Field Validation Tests
    // =====================================

    public function testMissingNameReturnsError(): void
    {
        $data = $this->validData;
        unset($data['name']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function testMissingSpeciesIdReturnsError(): void
    {
        $data = $this->validData;
        unset($data['speciesId']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('speciesId', $validator->errors()->toArray());
    }

    public function testNonExistentClassIdReturnsError(): void
    {
        $data              = $this->validData;
        $data['classId']   = Str::uuid()->toString();

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('classId', $validator->errors()->toArray());
    }

    public function testNonIntegerScoreReturnsError(): void
    {
        $data = $this->validData;
        /** @var array<string, mixed> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 'ten';
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores.strength', $validator->errors()->toArray());
    }

    public function testPersonalityTraitsMaxLength(): void
    {
        $data                      = $this->validData;
        $data['personalityTraits'] = str_repeat('a', 1001);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('personalityTraits', $validator->errors()->toArray());
    }

    public function testScoreAboveMaximumReturnsError(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 19;
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores.strength', $validator->errors()->toArray());
    }

    public function testScoreAtMaximumPasses(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 18;
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    public function testScoreAtMinimumPasses(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 3;
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    // =====================================
    // Ability Score Validation Tests
    // =====================================

    public function testScoreBelowMinimumReturnsError(): void
    {
        $data = $this->validData;
        /** @var array<string, int> $abilityScores */
        $abilityScores             = $data['abilityScores'];
        $abilityScores['strength'] = 2;
        $data['abilityScores']     = $abilityScores;

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('abilityScores.strength', $validator->errors()->toArray());
    }

    public function testValidClassIdPasses(): void
    {
        $validator = $this->makeValidator($this->validData);

        $this->assertFalse($validator->fails());
    }

    // =====================================
    // Valid Data Tests
    // =====================================

    public function testValidDataPasses(): void
    {
        $validator = $this->makeValidator($this->validData);

        $this->assertFalse($validator->fails());
    }

    public function testValidDataWithOptionalFieldsPasses(): void
    {
        $data                      = $this->validData;
        $data['alignment']         = 'lawful_good';
        $data['backstory']         = 'A heroic tale';
        $data['personalityTraits'] = 'Brave and bold';
        $data['ideals']            = 'Justice for all';
        $data['bonds']             = 'Family first';
        $data['flaws']             = 'Too trusting';

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->fails());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $this->validData = [
            'name'          => 'Test Character',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 15,
                'dexterity'    => 14,
                'constitution' => 13,
                'intelligence' => 12,
                'wisdom'       => 10,
                'charisma'     => 8,
            ],
        ];
    }

    /**
     * Create a validator for the given data using StoreCharacterRequest rules.
     *
     * @param array<string, mixed> $data
     */
    private function makeValidator(array $data): \Illuminate\Validation\Validator
    {
        $request = new StoreCharacterRequest();

        return Validator::make(
            $data,
            $request->rules(),
            $request->messages(),
            $request->attributes()
        );
    }
}
