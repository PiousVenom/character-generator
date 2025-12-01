<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Background;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Feature tests for Background API endpoints (read-only).
 */
final class BackgroundControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexIncludesCorrelationIdHeader(): void
    {
        $response = $this->getJson('/api/v1/backgrounds');

        $response->assertHeader('X-Correlation-ID');
    }

    public function testIndexReturnsAllBackgrounds(): void
    {
        Background::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/backgrounds');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    public function testIndexReturnsCamelCaseFields(): void
    {
        Background::factory()->create([
            'skill_proficiencies' => ['athletics', 'intimidation'],
            'tool_proficiency'    => 'gaming-set',
            'starting_equipment'  => [['item' => 'Spear', 'quantity' => 1]],
            'starting_gold'       => 14.00,
        ]);

        $response = $this->getJson('/api/v1/backgrounds');

        $response->assertOk();
        $data = $response->json('data.0');
        $this->assertIsArray($data);
        $this->assertArrayHasKey('skillProficiencies', $data);
        $this->assertArrayHasKey('toolProficiency', $data);
        $this->assertArrayHasKey('startingEquipment', $data);
        $this->assertArrayHasKey('startingGold', $data);
    }

    public function testIndexReturnsCorrectStructure(): void
    {
        Background::factory()->create([
            'name' => 'Soldier',
            'slug' => 'soldier',
        ]);

        $response = $this->getJson('/api/v1/backgrounds');

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                ],
            ],
            'message',
            'meta',
        ]);
    }

    // =====================================
    // GET /api/v1/backgrounds
    // =====================================

    public function testIndexReturnsEmptyArrayWhenNoBackgrounds(): void
    {
        $response = $this->getJson('/api/v1/backgrounds');

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data'    => [],
        ]);
    }

    public function testShowIncludesStartingEquipment(): void
    {
        $background = Background::factory()->create([
            'starting_equipment' => [
                ['item' => 'Spear', 'quantity' => 1],
                ['item' => 'Shortbow', 'quantity' => 1],
                ['item' => 'Arrow', 'quantity' => 20],
            ],
        ]);

        $response = $this->getJson("/api/v1/backgrounds/{$background->id}");

        $response->assertOk();
        $equipment = $response->json('data.startingEquipment');
        $this->assertIsArray($equipment);
        $this->assertCount(3, $equipment);
    }

    public function testShowReturns404ForInvalidUuidFormat(): void
    {
        $response = $this->getJson('/api/v1/backgrounds/not-a-uuid');

        $response->assertNotFound();
    }

    public function testShowReturns404ForNonExistentBackground(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/backgrounds/{$fakeUuid}");

        $response->assertNotFound();
    }

    // =====================================
    // GET /api/v1/backgrounds/{uuid}
    // =====================================

    public function testShowReturnsBackground(): void
    {
        $background = Background::factory()->create([
            'name'                => 'Sage',
            'skill_proficiencies' => ['arcana', 'history'],
            'tool_proficiency'    => 'calligraphers-supplies',
        ]);

        $response = $this->getJson("/api/v1/backgrounds/{$background->id}");

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.id', $background->id);
        $response->assertJsonPath('data.name', 'Sage');
        $response->assertJsonPath('data.skillProficiencies', ['arcana', 'history']);
        $response->assertJsonPath('data.toolProficiency', 'calligraphers-supplies');
    }

    public function testShowReturnsCamelCaseFields(): void
    {
        $background = Background::factory()->create([
            'skill_proficiencies' => ['stealth', 'sleight-of-hand'],
            'starting_gold'       => 15.50,
        ]);

        $response = $this->getJson("/api/v1/backgrounds/{$background->id}");

        $response->assertOk();
        $response->assertJsonPath('data.skillProficiencies', ['stealth', 'sleight-of-hand']);
        // startingGold may be string or float depending on cast
        $this->assertNotNull($response->json('data.startingGold'));
    }
}
