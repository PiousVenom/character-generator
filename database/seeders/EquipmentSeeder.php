<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

final class EquipmentSeeder extends Seeder
{
    /**
     * @var array<array<string, mixed>>
     */
    private array $equipment = [
        // Simple Melee Weapons
        ['name' => 'Club', 'slug' => 'club', 'description' => 'A simple wooden club.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 10, 'weight_lb' => 2.0, 'damage_dice' => '1d4', 'damage_type' => 'bludgeoning', 'properties' => ['light']],
        ['name' => 'Dagger', 'slug' => 'dagger', 'description' => 'A short blade for close combat.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 200, 'weight_lb' => 1.0, 'damage_dice' => '1d4', 'damage_type' => 'piercing', 'range_normal' => 20, 'range_long' => 60, 'properties' => ['finesse', 'light', 'thrown']],
        ['name' => 'Greatclub', 'slug' => 'greatclub', 'description' => 'A large, heavy club.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 20, 'weight_lb' => 10.0, 'damage_dice' => '1d8', 'damage_type' => 'bludgeoning', 'properties' => ['two-handed']],
        ['name' => 'Handaxe', 'slug' => 'handaxe', 'description' => 'A small axe for throwing or melee.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 500, 'weight_lb' => 2.0, 'damage_dice' => '1d6', 'damage_type' => 'slashing', 'range_normal' => 20, 'range_long' => 60, 'properties' => ['light', 'thrown']],
        ['name' => 'Javelin', 'slug' => 'javelin', 'description' => 'A light spear for throwing.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 50, 'weight_lb' => 2.0, 'damage_dice' => '1d6', 'damage_type' => 'piercing', 'range_normal' => 30, 'range_long' => 120, 'properties' => ['thrown']],
        ['name' => 'Light Hammer', 'slug' => 'light-hammer', 'description' => 'A small hammer for throwing or melee.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 200, 'weight_lb' => 2.0, 'damage_dice' => '1d4', 'damage_type' => 'bludgeoning', 'range_normal' => 20, 'range_long' => 60, 'properties' => ['light', 'thrown']],
        ['name' => 'Mace', 'slug' => 'mace', 'description' => 'A heavy club with a metal head.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 500, 'weight_lb' => 4.0, 'damage_dice' => '1d6', 'damage_type' => 'bludgeoning', 'properties' => []],
        ['name' => 'Quarterstaff', 'slug' => 'quarterstaff', 'description' => 'A versatile wooden staff.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 20, 'weight_lb' => 4.0, 'damage_dice' => '1d6', 'damage_type' => 'bludgeoning', 'properties' => ['versatile-1d8']],
        ['name' => 'Sickle', 'slug' => 'sickle', 'description' => 'A curved blade for farming or combat.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 100, 'weight_lb' => 2.0, 'damage_dice' => '1d4', 'damage_type' => 'slashing', 'properties' => ['light']],
        ['name' => 'Spear', 'slug' => 'spear', 'description' => 'A versatile polearm.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-melee', 'cost_cp' => 100, 'weight_lb' => 3.0, 'damage_dice' => '1d6', 'damage_type' => 'piercing', 'range_normal' => 20, 'range_long' => 60, 'properties' => ['thrown', 'versatile-1d8']],

        // Simple Ranged Weapons
        ['name' => 'Light Crossbow', 'slug' => 'light-crossbow', 'description' => 'A ranged weapon that fires bolts.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-ranged', 'cost_cp' => 2500, 'weight_lb' => 5.0, 'damage_dice' => '1d8', 'damage_type' => 'piercing', 'range_normal' => 80, 'range_long' => 320, 'properties' => ['ammunition', 'loading', 'two-handed']],
        ['name' => 'Dart', 'slug' => 'dart', 'description' => 'A small throwing weapon.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-ranged', 'cost_cp' => 5, 'weight_lb' => 0.25, 'damage_dice' => '1d4', 'damage_type' => 'piercing', 'range_normal' => 20, 'range_long' => 60, 'properties' => ['finesse', 'thrown']],
        ['name' => 'Shortbow', 'slug' => 'shortbow', 'description' => 'A small bow for ranged attacks.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-ranged', 'cost_cp' => 2500, 'weight_lb' => 2.0, 'damage_dice' => '1d6', 'damage_type' => 'piercing', 'range_normal' => 80, 'range_long' => 320, 'properties' => ['ammunition', 'two-handed']],
        ['name' => 'Sling', 'slug' => 'sling', 'description' => 'A simple ranged weapon using stones.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'simple-ranged', 'cost_cp' => 10, 'weight_lb' => 0.0, 'damage_dice' => '1d4', 'damage_type' => 'bludgeoning', 'range_normal' => 30, 'range_long' => 120, 'properties' => ['ammunition']],

        // Martial Melee Weapons
        ['name' => 'Battleaxe', 'slug' => 'battleaxe', 'description' => 'A versatile axe for combat.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1000, 'weight_lb' => 4.0, 'damage_dice' => '1d8', 'damage_type' => 'slashing', 'properties' => ['versatile-1d10']],
        ['name' => 'Flail', 'slug' => 'flail', 'description' => 'A weapon with a spiked ball on a chain.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1000, 'weight_lb' => 2.0, 'damage_dice' => '1d8', 'damage_type' => 'bludgeoning', 'properties' => []],
        ['name' => 'Glaive', 'slug' => 'glaive', 'description' => 'A polearm with a single-edged blade.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 2000, 'weight_lb' => 6.0, 'damage_dice' => '1d10', 'damage_type' => 'slashing', 'properties' => ['heavy', 'reach', 'two-handed']],
        ['name' => 'Greataxe', 'slug' => 'greataxe', 'description' => 'A massive two-handed axe.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 3000, 'weight_lb' => 7.0, 'damage_dice' => '1d12', 'damage_type' => 'slashing', 'properties' => ['heavy', 'two-handed']],
        ['name' => 'Greatsword', 'slug' => 'greatsword', 'description' => 'A massive two-handed sword.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 5000, 'weight_lb' => 6.0, 'damage_dice' => '2d6', 'damage_type' => 'slashing', 'properties' => ['heavy', 'two-handed']],
        ['name' => 'Halberd', 'slug' => 'halberd', 'description' => 'A polearm with an axe blade and spike.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 2000, 'weight_lb' => 6.0, 'damage_dice' => '1d10', 'damage_type' => 'slashing', 'properties' => ['heavy', 'reach', 'two-handed']],
        ['name' => 'Lance', 'slug' => 'lance', 'description' => 'A cavalry weapon with reach.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1000, 'weight_lb' => 6.0, 'damage_dice' => '1d12', 'damage_type' => 'piercing', 'properties' => ['reach', 'special']],
        ['name' => 'Longsword', 'slug' => 'longsword', 'description' => 'A versatile sword.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1500, 'weight_lb' => 3.0, 'damage_dice' => '1d8', 'damage_type' => 'slashing', 'properties' => ['versatile-1d10']],
        ['name' => 'Maul', 'slug' => 'maul', 'description' => 'A massive two-handed hammer.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1000, 'weight_lb' => 10.0, 'damage_dice' => '2d6', 'damage_type' => 'bludgeoning', 'properties' => ['heavy', 'two-handed']],
        ['name' => 'Morningstar', 'slug' => 'morningstar', 'description' => 'A spiked mace.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1500, 'weight_lb' => 4.0, 'damage_dice' => '1d8', 'damage_type' => 'piercing', 'properties' => []],
        ['name' => 'Pike', 'slug' => 'pike', 'description' => 'A long spear with reach.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 500, 'weight_lb' => 18.0, 'damage_dice' => '1d10', 'damage_type' => 'piercing', 'properties' => ['heavy', 'reach', 'two-handed']],
        ['name' => 'Rapier', 'slug' => 'rapier', 'description' => 'A slender thrusting sword.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 2500, 'weight_lb' => 2.0, 'damage_dice' => '1d8', 'damage_type' => 'piercing', 'properties' => ['finesse']],
        ['name' => 'Scimitar', 'slug' => 'scimitar', 'description' => 'A curved blade.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 2500, 'weight_lb' => 3.0, 'damage_dice' => '1d6', 'damage_type' => 'slashing', 'properties' => ['finesse', 'light']],
        ['name' => 'Shortsword', 'slug' => 'shortsword', 'description' => 'A short blade for quick strikes.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1000, 'weight_lb' => 2.0, 'damage_dice' => '1d6', 'damage_type' => 'piercing', 'properties' => ['finesse', 'light']],
        ['name' => 'Trident', 'slug' => 'trident', 'description' => 'A three-pronged spear.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 500, 'weight_lb' => 4.0, 'damage_dice' => '1d6', 'damage_type' => 'piercing', 'range_normal' => 20, 'range_long' => 60, 'properties' => ['thrown', 'versatile-1d8']],
        ['name' => 'War Pick', 'slug' => 'war-pick', 'description' => 'A pointed hammer for armor piercing.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 500, 'weight_lb' => 2.0, 'damage_dice' => '1d8', 'damage_type' => 'piercing', 'properties' => []],
        ['name' => 'Warhammer', 'slug' => 'warhammer', 'description' => 'A versatile hammer.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 1500, 'weight_lb' => 2.0, 'damage_dice' => '1d8', 'damage_type' => 'bludgeoning', 'properties' => ['versatile-1d10']],
        ['name' => 'Whip', 'slug' => 'whip', 'description' => 'A flexible weapon with reach.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-melee', 'cost_cp' => 200, 'weight_lb' => 3.0, 'damage_dice' => '1d4', 'damage_type' => 'slashing', 'properties' => ['finesse', 'reach']],

        // Martial Ranged Weapons
        ['name' => 'Blowgun', 'slug' => 'blowgun', 'description' => 'A tube for shooting darts.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-ranged', 'cost_cp' => 1000, 'weight_lb' => 1.0, 'damage_dice' => '1', 'damage_type' => 'piercing', 'range_normal' => 25, 'range_long' => 100, 'properties' => ['ammunition', 'loading']],
        ['name' => 'Hand Crossbow', 'slug' => 'hand-crossbow', 'description' => 'A small crossbow for one hand.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-ranged', 'cost_cp' => 7500, 'weight_lb' => 3.0, 'damage_dice' => '1d6', 'damage_type' => 'piercing', 'range_normal' => 30, 'range_long' => 120, 'properties' => ['ammunition', 'light', 'loading']],
        ['name' => 'Heavy Crossbow', 'slug' => 'heavy-crossbow', 'description' => 'A large crossbow for heavy damage.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-ranged', 'cost_cp' => 5000, 'weight_lb' => 18.0, 'damage_dice' => '1d10', 'damage_type' => 'piercing', 'range_normal' => 100, 'range_long' => 400, 'properties' => ['ammunition', 'heavy', 'loading', 'two-handed']],
        ['name' => 'Longbow', 'slug' => 'longbow', 'description' => 'A tall bow for long range.', 'equipment_type' => 'weapon', 'equipment_subtype' => 'martial-ranged', 'cost_cp' => 5000, 'weight_lb' => 2.0, 'damage_dice' => '1d8', 'damage_type' => 'piercing', 'range_normal' => 150, 'range_long' => 600, 'properties' => ['ammunition', 'heavy', 'two-handed']],

        // Armor - Light
        ['name' => 'Padded Armor', 'slug' => 'padded-armor', 'description' => 'Quilted layers of cloth and batting.', 'equipment_type' => 'armor', 'equipment_subtype' => 'light', 'cost_cp' => 500, 'weight_lb' => 8.0, 'armor_class' => 11, 'stealth_disadvantage' => true, 'properties' => []],
        ['name' => 'Leather Armor', 'slug' => 'leather-armor', 'description' => 'Chest and shoulder protection made of leather.', 'equipment_type' => 'armor', 'equipment_subtype' => 'light', 'cost_cp' => 1000, 'weight_lb' => 10.0, 'armor_class' => 11, 'stealth_disadvantage' => false, 'properties' => []],
        ['name' => 'Studded Leather Armor', 'slug' => 'studded-leather-armor', 'description' => 'Leather reinforced with close-set rivets.', 'equipment_type' => 'armor', 'equipment_subtype' => 'light', 'cost_cp' => 4500, 'weight_lb' => 13.0, 'armor_class' => 12, 'stealth_disadvantage' => false, 'properties' => []],

        // Armor - Medium
        ['name' => 'Hide Armor', 'slug' => 'hide-armor', 'description' => 'Crude armor made from thick furs and pelts.', 'equipment_type' => 'armor', 'equipment_subtype' => 'medium', 'cost_cp' => 1000, 'weight_lb' => 12.0, 'armor_class' => 12, 'armor_dex_cap' => 2, 'stealth_disadvantage' => false, 'properties' => []],
        ['name' => 'Chain Shirt', 'slug' => 'chain-shirt', 'description' => 'Interlocking metal rings worn under clothing.', 'equipment_type' => 'armor', 'equipment_subtype' => 'medium', 'cost_cp' => 5000, 'weight_lb' => 20.0, 'armor_class' => 13, 'armor_dex_cap' => 2, 'stealth_disadvantage' => false, 'properties' => []],
        ['name' => 'Scale Mail', 'slug' => 'scale-mail', 'description' => 'Overlapping metal scales on a leather backing.', 'equipment_type' => 'armor', 'equipment_subtype' => 'medium', 'cost_cp' => 5000, 'weight_lb' => 45.0, 'armor_class' => 14, 'armor_dex_cap' => 2, 'stealth_disadvantage' => true, 'properties' => []],
        ['name' => 'Breastplate', 'slug' => 'breastplate', 'description' => 'A fitted metal chest piece.', 'equipment_type' => 'armor', 'equipment_subtype' => 'medium', 'cost_cp' => 40000, 'weight_lb' => 20.0, 'armor_class' => 14, 'armor_dex_cap' => 2, 'stealth_disadvantage' => false, 'properties' => []],
        ['name' => 'Half Plate', 'slug' => 'half-plate', 'description' => 'Shaped metal plates covering vital areas.', 'equipment_type' => 'armor', 'equipment_subtype' => 'medium', 'cost_cp' => 75000, 'weight_lb' => 40.0, 'armor_class' => 15, 'armor_dex_cap' => 2, 'stealth_disadvantage' => true, 'properties' => []],

        // Armor - Heavy
        ['name' => 'Ring Mail', 'slug' => 'ring-mail', 'description' => 'Leather armor with metal rings sewn in.', 'equipment_type' => 'armor', 'equipment_subtype' => 'heavy', 'cost_cp' => 3000, 'weight_lb' => 40.0, 'armor_class' => 14, 'armor_dex_cap' => 0, 'stealth_disadvantage' => true, 'properties' => []],
        ['name' => 'Chain Mail', 'slug' => 'chain-mail', 'description' => 'Interlocking metal rings forming a mesh.', 'equipment_type' => 'armor', 'equipment_subtype' => 'heavy', 'cost_cp' => 7500, 'weight_lb' => 55.0, 'armor_class' => 16, 'armor_dex_cap' => 0, 'strength_requirement' => 13, 'stealth_disadvantage' => true, 'properties' => []],
        ['name' => 'Splint Armor', 'slug' => 'splint-armor', 'description' => 'Vertical strips of metal riveted to leather.', 'equipment_type' => 'armor', 'equipment_subtype' => 'heavy', 'cost_cp' => 20000, 'weight_lb' => 60.0, 'armor_class' => 17, 'armor_dex_cap' => 0, 'strength_requirement' => 15, 'stealth_disadvantage' => true, 'properties' => []],
        ['name' => 'Plate Armor', 'slug' => 'plate-armor', 'description' => 'Shaped, interlocking metal plates.', 'equipment_type' => 'armor', 'equipment_subtype' => 'heavy', 'cost_cp' => 150000, 'weight_lb' => 65.0, 'armor_class' => 18, 'armor_dex_cap' => 0, 'strength_requirement' => 15, 'stealth_disadvantage' => true, 'properties' => []],

        // Shield
        ['name' => 'Shield', 'slug' => 'shield', 'description' => 'A wooden or metal shield carried in one hand.', 'equipment_type' => 'armor', 'equipment_subtype' => 'shield', 'cost_cp' => 1000, 'weight_lb' => 6.0, 'armor_class' => 2, 'stealth_disadvantage' => false, 'properties' => []],

        // Adventuring Gear
        ['name' => 'Backpack', 'slug' => 'backpack', 'description' => 'A pack for carrying items on your back.', 'equipment_type' => 'gear', 'equipment_subtype' => 'container', 'cost_cp' => 200, 'weight_lb' => 5.0, 'properties' => ['capacity' => '30 lb']],
        ['name' => 'Bedroll', 'slug' => 'bedroll', 'description' => 'A padded sleeping roll.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 100, 'weight_lb' => 7.0, 'properties' => []],
        ['name' => 'Crowbar', 'slug' => 'crowbar', 'description' => 'An iron bar for prying.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 200, 'weight_lb' => 5.0, 'properties' => []],
        ['name' => 'Healer\'s Kit', 'slug' => 'healers-kit', 'description' => 'A kit with bandages and salves.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 500, 'weight_lb' => 3.0, 'properties' => ['uses' => 10]],
        ['name' => 'Rations (1 day)', 'slug' => 'rations', 'description' => 'Dried food for one day.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 50, 'weight_lb' => 2.0, 'properties' => []],
        ['name' => 'Rope (50 feet)', 'slug' => 'rope', 'description' => 'Hempen rope, 50 feet.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 100, 'weight_lb' => 10.0, 'properties' => []],
        ['name' => 'Torch', 'slug' => 'torch', 'description' => 'A wooden torch that burns for 1 hour.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 1, 'weight_lb' => 1.0, 'properties' => ['duration' => '1 hour', 'light' => '20 ft bright, 20 ft dim']],
        ['name' => 'Waterskin', 'slug' => 'waterskin', 'description' => 'A leather container for water.', 'equipment_type' => 'gear', 'equipment_subtype' => 'adventuring', 'cost_cp' => 20, 'weight_lb' => 5.0, 'properties' => ['capacity' => '4 pints']],

        // Tools
        ['name' => 'Thieves\' Tools', 'slug' => 'thieves-tools', 'description' => 'A set of tools for picking locks and disarming traps.', 'equipment_type' => 'tool', 'equipment_subtype' => 'other', 'cost_cp' => 2500, 'weight_lb' => 1.0, 'properties' => []],
        ['name' => 'Herbalism Kit', 'slug' => 'herbalism-kit', 'description' => 'A pouch of herbs and supplies for identifying plants.', 'equipment_type' => 'tool', 'equipment_subtype' => 'other', 'cost_cp' => 500, 'weight_lb' => 3.0, 'properties' => []],
        ['name' => 'Navigator\'s Tools', 'slug' => 'navigators-tools', 'description' => 'Tools for charting courses and navigating.', 'equipment_type' => 'tool', 'equipment_subtype' => 'other', 'cost_cp' => 2500, 'weight_lb' => 2.0, 'properties' => []],
        ['name' => 'Smith\'s Tools', 'slug' => 'smiths-tools', 'description' => 'Tools for working metal.', 'equipment_type' => 'tool', 'equipment_subtype' => 'artisan', 'cost_cp' => 2000, 'weight_lb' => 8.0, 'properties' => []],
        ['name' => 'Carpenter\'s Tools', 'slug' => 'carpenters-tools', 'description' => 'Tools for woodworking.', 'equipment_type' => 'tool', 'equipment_subtype' => 'artisan', 'cost_cp' => 800, 'weight_lb' => 6.0, 'properties' => []],
        ['name' => 'Calligrapher\'s Supplies', 'slug' => 'calligraphers-supplies', 'description' => 'Inks, pens, and parchment for calligraphy.', 'equipment_type' => 'tool', 'equipment_subtype' => 'artisan', 'cost_cp' => 1000, 'weight_lb' => 5.0, 'properties' => []],

        // Ammunition
        ['name' => 'Arrow', 'slug' => 'arrow', 'description' => 'An arrow for bows.', 'equipment_type' => 'gear', 'equipment_subtype' => 'ammunition', 'cost_cp' => 5, 'weight_lb' => 0.05, 'properties' => ['ammunition_for' => ['shortbow', 'longbow']]],
        ['name' => 'Bolt', 'slug' => 'bolt', 'description' => 'A bolt for crossbows.', 'equipment_type' => 'gear', 'equipment_subtype' => 'ammunition', 'cost_cp' => 5, 'weight_lb' => 0.075, 'properties' => ['ammunition_for' => ['light-crossbow', 'heavy-crossbow', 'hand-crossbow']]],
    ];

    public function run(): void
    {
        foreach ($this->equipment as $item) {
            Equipment::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
