<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\CharacterClass;
use App\Models\ClassFeature;
use App\Models\Subclass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class ClassControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_classes(): void
    {
        CharacterClass::factory()->count(12)->create();

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'hitDie',
                        'primaryAbility',
                        'savingThrowProficiencies',
                        'armorProficiencies',
                        'weaponProficiencies',
                        'toolProficiencies',
                        'skillChoicesCount',
                        'skillChoicesList',
                        'spellcastingAbility',
                    ],
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Classes retrieved successfully',
                'meta' => [
                    'version' => 'v1',
                ],
            ])
            ->assertJsonCount(12, 'data');
    }

    public function test_index_returns_classes_sorted_by_name(): void
    {
        CharacterClass::factory()->create(['name' => 'Wizard']);
        CharacterClass::factory()->create(['name' => 'Barbarian']);
        CharacterClass::factory()->create(['name' => 'Cleric']);

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();

        $names = collect($response->json('data'))->pluck('name')->all();
        $this->assertEquals(['Barbarian', 'Cleric', 'Wizard'], $names);
    }

    public function test_index_returns_empty_array_when_no_classes_exist(): void
    {
        $response = $this->getJson('/api/v1/classes');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Classes retrieved successfully',
            ]);
    }

    public function test_show_returns_single_class_with_relationships(): void
    {
        $class = CharacterClass::factory()->create([
            'name' => 'Wizard',
            'hit_die' => 6,
            'primary_ability' => 'intelligence',
        ]);

        ClassFeature::factory()->count(3)->create([
            'class_id' => $class->id,
        ]);

        Subclass::factory()->count(2)->create([
            'class_id' => $class->id,
        ]);

        $response = $this->getJson("/api/v1/classes/{$class->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'hitDie',
                    'primaryAbility',
                    'savingThrowProficiencies',
                    'armorProficiencies',
                    'weaponProficiencies',
                    'toolProficiencies',
                    'skillChoicesCount',
                    'skillChoicesList',
                    'spellcastingAbility',
                    'features' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'level',
                        ],
                    ],
                    'subclasses' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                        ],
                    ],
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Class retrieved successfully',
                'data' => [
                    'id' => $class->id,
                    'name' => 'Wizard',
                    'hitDie' => 6,
                    'primaryAbility' => 'intelligence',
                ],
            ])
            ->assertJsonCount(3, 'data.features')
            ->assertJsonCount(2, 'data.subclasses');
    }

    public function test_show_returns_404_for_non_existent_class(): void
    {
        $nonExistentId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/classes/{$nonExistentId}");

        $response->assertNotFound()
            ->assertJsonStructure([
                'success',
                'error' => [
                    'code',
                    'message',
                ],
                'meta' => [
                    'timestamp',
                    'correlationId',
                ],
            ])
            ->assertJson([
                'success' => false,
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'The requested resource was not found.',
                ],
            ]);
    }

    public function test_response_uses_camel_case_keys(): void
    {
        $class = CharacterClass::factory()->create([
            'hit_die' => 8,
            'primary_ability' => 'strength',
            'skill_choices_count' => 2,
            'skill_choices_list' => ['Athletics', 'Acrobatics'],
            'spellcasting_ability' => null,
        ]);

        $response = $this->getJson("/api/v1/classes/{$class->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'hitDie',
                    'primaryAbility',
                    'savingThrowProficiencies',
                    'armorProficiencies',
                    'weaponProficiencies',
                    'toolProficiencies',
                    'skillChoicesCount',
                    'skillChoicesList',
                    'spellcastingAbility',
                ],
            ]);

        $data = $response->json('data');
        $this->assertArrayNotHasKey('hit_die', $data);
        $this->assertArrayNotHasKey('primary_ability', $data);
        $this->assertArrayNotHasKey('skill_choices_count', $data);
    }

    public function test_response_includes_correlation_id(): void
    {
        $class = CharacterClass::factory()->create();

        $response = $this->getJson("/api/v1/classes/{$class->id}");

        $response->assertOk();

        $this->assertNotEmpty($response->headers->get('X-Correlation-ID'));
        $this->assertTrue(Str::isUuid($response->headers->get('X-Correlation-ID')));
    }

    public function test_response_echoes_provided_correlation_id(): void
    {
        $class = CharacterClass::factory()->create();
        $correlationId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/classes/{$class->id}", [
            'X-Correlation-ID' => $correlationId,
        ]);

        $response->assertOk();

        $this->assertEquals($correlationId, $response->headers->get('X-Correlation-ID'));
    }
}
