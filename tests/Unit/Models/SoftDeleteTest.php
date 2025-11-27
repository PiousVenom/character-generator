<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a character can be soft deleted.
     */
    public function test_character_can_be_soft_deleted(): void
    {
        $character = Character::factory()->create();
        $characterId = $character->id;

        $character->delete();

        $this->assertSoftDeleted('characters', ['id' => $characterId]);
    }

    /**
     * Test that a soft deleted character is not returned in queries.
     */
    public function test_soft_deleted_character_excluded_from_queries(): void
    {
        $character = Character::factory()->create();
        $characterId = $character->id;

        $character->delete();

        $this->assertEquals(0, Character::count());
        $this->assertNull(Character::find($characterId));
    }

    /**
     * Test that soft deleted characters can be included with withTrashed.
     */
    public function test_soft_deleted_characters_included_with_trashed(): void
    {
        $character = Character::factory()->create();

        $character->delete();

        $this->assertEquals(1, Character::withTrashed()->count());
        $this->assertNotNull(Character::withTrashed()->find($character->id));
    }

    /**
     * Test that only soft deleted records are returned with onlyTrashed.
     */
    public function test_only_trashed_returns_only_deleted_characters(): void
    {
        $character = Character::factory()->create();
        $character->delete();

        $this->assertEquals(1, Character::onlyTrashed()->count());
        $this->assertEquals(0, Character::count());
    }

    /**
     * Test that a soft deleted character can be restored.
     */
    public function test_soft_deleted_character_can_be_restored(): void
    {
        $character = Character::factory()->create();
        $characterId = $character->id;

        $character->delete();
        $this->assertSoftDeleted('characters', ['id' => $characterId]);

        $character->restore();
        $this->assertNotSoftDeleted('characters', ['id' => $characterId]);
    }

    /**
     * Test that character timestamps are preserved after soft delete.
     */
    public function test_soft_delete_preserves_timestamps(): void
    {
        $character = Character::factory()->create();
        $originalCreatedAt = $character->created_at;

        $character->delete();

        $trashedCharacter = Character::withTrashed()->find($character->id);
        $this->assertNotNull($trashedCharacter);
        $this->assertEquals($originalCreatedAt, $trashedCharacter->created_at);
    }

    /**
     * Test that a restored character is active again.
     */
    public function test_restored_character_is_active(): void
    {
        $character = Character::factory()->create();

        $character->delete();
        $this->assertEquals(0, Character::count());

        $character->restore();
        $this->assertEquals(1, Character::count());
    }

    /**
     * Test that character uses SoftDeletes trait.
     */
    public function test_character_uses_soft_deletes_trait(): void
    {
        $character = new Character();

        $this->assertTrue(
            in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($character), true),
            'Character model should use SoftDeletes trait',
        );
    }

    /**
     * Test that deleted characters remain soft deleted.
     */
    public function test_soft_deleted_character_has_deleted_at_timestamp(): void
    {
        $character = Character::factory()->create();

        $character->delete();

        $trashedCharacter = Character::withTrashed()->find($character->id);
        $this->assertNotNull($trashedCharacter?->deleted_at);
    }

    /**
     * Test that restored characters no longer have deleted_at timestamp.
     */
    public function test_restored_character_has_null_deleted_at(): void
    {
        $character = Character::factory()->create();

        $character->delete();
        $character->restore();

        $restoredCharacter = Character::find($character->id);
        $this->assertNull($restoredCharacter?->deleted_at);
    }

    /**
     * Test that soft delete is enforced by scope.
     */
    public function test_soft_delete_scope_works(): void
    {
        $character = Character::factory()->create();
        $characterId = $character->id;

        $character->delete();

        $this->assertEquals(0, Character::count());
        $this->assertNull(Character::find($characterId));
    }

    /**
     * Test that withTrashed includes both active and deleted records.
     */
    public function test_with_trashed_includes_both_active_and_deleted(): void
    {
        $character = Character::factory()->create();

        $character->delete();

        $this->assertEquals(1, Character::withTrashed()->count());
        $this->assertEquals(0, Character::count());
        $this->assertEquals(1, Character::onlyTrashed()->count());
    }
}
