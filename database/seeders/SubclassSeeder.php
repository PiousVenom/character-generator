<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Database\Seeder;

final class SubclassSeeder extends Seeder
{
    /**
     * @var array<array{class_slug: string, name: string, slug: string, description: string, source: string}>
     */
    private array $subclasses = [
        // Barbarian Subclasses
        ['class_slug' => 'barbarian', 'name' => 'Path of the Berserker', 'slug' => 'path-of-the-berserker', 'description' => 'For some barbarians, rage is a means to an end—that end being violence. The Path of the Berserker is a path of untrammeled fury.', 'source' => 'PHB 2024'],
        ['class_slug' => 'barbarian', 'name' => 'Path of the Totem Warrior', 'slug' => 'path-of-the-totem-warrior', 'description' => 'The Path of the Totem Warrior is a spiritual journey, as the barbarian accepts a spirit animal as guide, protector, and inspiration.', 'source' => 'PHB 2024'],
        ['class_slug' => 'barbarian', 'name' => 'Path of Wild Magic', 'slug' => 'path-of-wild-magic', 'description' => 'Many places in the multiverse abound with beauty, intense emotion, and rampant magic; the Feywild, the Upper Planes, and other realms of supernatural power radiate with such forces.', 'source' => 'PHB 2024'],
        ['class_slug' => 'barbarian', 'name' => 'Path of the World Tree', 'slug' => 'path-of-the-world-tree', 'description' => 'Barbarians who follow the Path of the World Tree connect with the cosmic tree that links all the worlds of the multiverse.', 'source' => 'PHB 2024'],

        // Bard Subclasses
        ['class_slug' => 'bard', 'name' => 'College of Lore', 'slug' => 'college-of-lore', 'description' => 'Bards of the College of Lore know something about most things, collecting bits of knowledge from sources as diverse as scholarly tomes and peasant tales.', 'source' => 'PHB 2024'],
        ['class_slug' => 'bard', 'name' => 'College of Valor', 'slug' => 'college-of-valor', 'description' => 'Bards of the College of Valor are daring skalds whose tales keep alive the memory of the great heroes of the past.', 'source' => 'PHB 2024'],
        ['class_slug' => 'bard', 'name' => 'College of Glamour', 'slug' => 'college-of-glamour', 'description' => 'The College of Glamour is the home of bards who mastered their craft in the vibrant realm of the Feywild or under the tutelage of someone who dwelled there.', 'source' => 'PHB 2024'],
        ['class_slug' => 'bard', 'name' => 'College of Dance', 'slug' => 'college-of-dance', 'description' => 'Bards of the College of Dance use motion to express themselves, moving with the rhythm of the world.', 'source' => 'PHB 2024'],

        // Cleric Subclasses
        ['class_slug' => 'cleric', 'name' => 'Life Domain', 'slug' => 'life-domain', 'description' => 'The Life domain focuses on the vibrant positive energy—one of the fundamental forces of the universe—that sustains all life.', 'source' => 'PHB 2024'],
        ['class_slug' => 'cleric', 'name' => 'Light Domain', 'slug' => 'light-domain', 'description' => 'Gods of light—including Helm, Lathander, Pholtus, Branchala, the Silver Flame, Belenus, Apollo, and Re-Horakhty—promote the ideals of rebirth and renewal.', 'source' => 'PHB 2024'],
        ['class_slug' => 'cleric', 'name' => 'Trickery Domain', 'slug' => 'trickery-domain', 'description' => 'Gods of trickery—such as Tymora, Beshaba, Olidammara, the Traveler, Garl Glittergold, and Loki—are mischief-makers and instigators.', 'source' => 'PHB 2024'],
        ['class_slug' => 'cleric', 'name' => 'War Domain', 'slug' => 'war-domain', 'description' => 'War has many manifestations. It can make heroes of ordinary people. It can be desperate and horrific, with acts of cruelty and cowardice eclipsing instances of excellence and courage.', 'source' => 'PHB 2024'],

        // Druid Subclasses
        ['class_slug' => 'druid', 'name' => 'Circle of the Land', 'slug' => 'circle-of-the-land', 'description' => 'The Circle of the Land is made up of mystics and sages who safeguard ancient knowledge and rites through a vast oral tradition.', 'source' => 'PHB 2024'],
        ['class_slug' => 'druid', 'name' => 'Circle of the Moon', 'slug' => 'circle-of-the-moon', 'description' => 'Druids of the Circle of the Moon are fierce guardians of the wilds. Their order gathers under the full moon to share news and trade warnings.', 'source' => 'PHB 2024'],
        ['class_slug' => 'druid', 'name' => 'Circle of the Sea', 'slug' => 'circle-of-the-sea', 'description' => 'Druids of the Circle of the Sea draw on the power of the ocean, calling upon its might to smite foes and protect allies.', 'source' => 'PHB 2024'],
        ['class_slug' => 'druid', 'name' => 'Circle of Stars', 'slug' => 'circle-of-stars', 'description' => 'The Circle of Stars allows druids to draw on the power of starlight to guide them through the dark and illuminate the mysteries of the multiverse.', 'source' => 'PHB 2024'],

        // Fighter Subclasses
        ['class_slug' => 'fighter', 'name' => 'Champion', 'slug' => 'champion', 'description' => 'The archetypal Champion focuses on the development of raw physical power honed to deadly perfection.', 'source' => 'PHB 2024'],
        ['class_slug' => 'fighter', 'name' => 'Battle Master', 'slug' => 'battle-master', 'description' => 'Those who emulate the archetypal Battle Master employ martial techniques passed down through generations.', 'source' => 'PHB 2024'],
        ['class_slug' => 'fighter', 'name' => 'Eldritch Knight', 'slug' => 'eldritch-knight', 'description' => 'The archetypal Eldritch Knight combines the martial mastery common to all fighters with a careful study of magic.', 'source' => 'PHB 2024'],
        ['class_slug' => 'fighter', 'name' => 'Psi Warrior', 'slug' => 'psi-warrior', 'description' => 'Awake to the psionic power within, a Psi Warrior is a fighter who augments their physical might with psi-infused weapon strikes.', 'source' => 'PHB 2024'],

        // Monk Subclasses
        ['class_slug' => 'monk', 'name' => 'Warrior of the Open Hand', 'slug' => 'warrior-of-the-open-hand', 'description' => 'Warriors of the Open Hand are the ultimate masters of martial arts combat, whether armed or unarmed.', 'source' => 'PHB 2024'],
        ['class_slug' => 'monk', 'name' => 'Warrior of Shadow', 'slug' => 'warrior-of-shadow', 'description' => 'Warriors of Shadow follow a tradition that values stealth and subterfuge, using darkness to their advantage.', 'source' => 'PHB 2024'],
        ['class_slug' => 'monk', 'name' => 'Warrior of the Elements', 'slug' => 'warrior-of-the-elements', 'description' => 'Warriors of the Elements learn to tap into the primal forces of nature, channeling elemental power into their attacks.', 'source' => 'PHB 2024'],
        ['class_slug' => 'monk', 'name' => 'Warrior of Mercy', 'slug' => 'warrior-of-mercy', 'description' => 'Warriors of Mercy learn to manipulate the life force of others to bring aid to those in need.', 'source' => 'PHB 2024'],

        // Paladin Subclasses
        ['class_slug' => 'paladin', 'name' => 'Oath of Devotion', 'slug' => 'oath-of-devotion', 'description' => 'The Oath of Devotion binds a paladin to the loftiest ideals of justice, virtue, and order.', 'source' => 'PHB 2024'],
        ['class_slug' => 'paladin', 'name' => 'Oath of the Ancients', 'slug' => 'oath-of-the-ancients', 'description' => 'The Oath of the Ancients is as old as the race of elves and the rituals of the druids.', 'source' => 'PHB 2024'],
        ['class_slug' => 'paladin', 'name' => 'Oath of Vengeance', 'slug' => 'oath-of-vengeance', 'description' => 'The Oath of Vengeance is a solemn commitment to punish those who have committed a grievous sin.', 'source' => 'PHB 2024'],
        ['class_slug' => 'paladin', 'name' => 'Oath of Glory', 'slug' => 'oath-of-glory', 'description' => 'Paladins who take the Oath of Glory believe they and their companions are destined to achieve glory through deeds of heroism.', 'source' => 'PHB 2024'],

        // Ranger Subclasses
        ['class_slug' => 'ranger', 'name' => 'Hunter', 'slug' => 'hunter', 'description' => 'Emulating the Hunter archetype means accepting your place as a bulwark between civilization and the terrors of the wilderness.', 'source' => 'PHB 2024'],
        ['class_slug' => 'ranger', 'name' => 'Beast Master', 'slug' => 'beast-master', 'description' => 'The Beast Master archetype embodies a friendship between the civilized races and the beasts of the world.', 'source' => 'PHB 2024'],
        ['class_slug' => 'ranger', 'name' => 'Gloom Stalker', 'slug' => 'gloom-stalker', 'description' => 'Gloom Stalkers are at home in the darkest places: deep under the earth, in gloomy alleyways, in primeval forests.', 'source' => 'PHB 2024'],
        ['class_slug' => 'ranger', 'name' => 'Fey Wanderer', 'slug' => 'fey-wanderer', 'description' => 'A Fey Wanderer has a connection to the Feywild, possibly because of the influence of a Fey creature in their life.', 'source' => 'PHB 2024'],

        // Rogue Subclasses
        ['class_slug' => 'rogue', 'name' => 'Thief', 'slug' => 'thief', 'description' => 'You hone your skills in the larcenous arts. Burglars, bandits, cutpurses, and other criminals typically follow this archetype.', 'source' => 'PHB 2024'],
        ['class_slug' => 'rogue', 'name' => 'Assassin', 'slug' => 'assassin', 'description' => 'You focus your training on the grim art of death. Those who adhere to this archetype are diverse.', 'source' => 'PHB 2024'],
        ['class_slug' => 'rogue', 'name' => 'Arcane Trickster', 'slug' => 'arcane-trickster', 'description' => 'Some rogues enhance their fine-honed skills of stealth and agility with magic.', 'source' => 'PHB 2024'],
        ['class_slug' => 'rogue', 'name' => 'Soulknife', 'slug' => 'soulknife', 'description' => 'Most assassins strike with physical weapons, and many burglars and spies use thieves\' tools to infiltrate secure locations.', 'source' => 'PHB 2024'],

        // Sorcerer Subclasses
        ['class_slug' => 'sorcerer', 'name' => 'Draconic Bloodline', 'slug' => 'draconic-bloodline', 'description' => 'Your innate magic comes from draconic magic that was mingled with your blood or that of your ancestors.', 'source' => 'PHB 2024'],
        ['class_slug' => 'sorcerer', 'name' => 'Wild Magic', 'slug' => 'wild-magic', 'description' => 'Your innate magic comes from the wild forces of chaos that underlie the order of creation.', 'source' => 'PHB 2024'],
        ['class_slug' => 'sorcerer', 'name' => 'Aberrant Sorcery', 'slug' => 'aberrant-sorcery', 'description' => 'An alien influence has wrapped its tendrils around your mind, giving you psionic power.', 'source' => 'PHB 2024'],
        ['class_slug' => 'sorcerer', 'name' => 'Clockwork Soul', 'slug' => 'clockwork-soul', 'description' => 'The cosmic force of order has suffused you with magic. That power arises from Mechanus or a realm like it.', 'source' => 'PHB 2024'],

        // Warlock Subclasses
        ['class_slug' => 'warlock', 'name' => 'The Archfey', 'slug' => 'the-archfey', 'description' => 'Your patron is a lord or lady of the fey, a creature of legend who holds secrets that were forgotten before the mortal races were born.', 'source' => 'PHB 2024'],
        ['class_slug' => 'warlock', 'name' => 'The Fiend', 'slug' => 'the-fiend', 'description' => 'You have made a pact with a fiend from the lower planes of existence, a being whose aims are evil.', 'source' => 'PHB 2024'],
        ['class_slug' => 'warlock', 'name' => 'The Great Old One', 'slug' => 'the-great-old-one', 'description' => 'Your patron is a mysterious entity whose nature is utterly foreign to the fabric of reality.', 'source' => 'PHB 2024'],
        ['class_slug' => 'warlock', 'name' => 'The Celestial', 'slug' => 'the-celestial', 'description' => 'Your patron is a powerful being of the Upper Planes. You have bound yourself to an ancient empyrean, solar, ki-rin, unicorn, or other entity.', 'source' => 'PHB 2024'],

        // Wizard Subclasses
        ['class_slug' => 'wizard', 'name' => 'School of Abjuration', 'slug' => 'school-of-abjuration', 'description' => 'The School of Abjuration emphasizes magic that blocks, banishes, or protects.', 'source' => 'PHB 2024'],
        ['class_slug' => 'wizard', 'name' => 'School of Divination', 'slug' => 'school-of-divination', 'description' => 'The counsel of a diviner is sought by royalty and commoners alike, for all seek a clearer understanding of the past, present, and future.', 'source' => 'PHB 2024'],
        ['class_slug' => 'wizard', 'name' => 'School of Evocation', 'slug' => 'school-of-evocation', 'description' => 'You focus your study on magic that creates powerful elemental effects such as bitter cold, searing flame, rolling thunder, crackling lightning, and burning acid.', 'source' => 'PHB 2024'],
        ['class_slug' => 'wizard', 'name' => 'School of Illusion', 'slug' => 'school-of-illusion', 'description' => 'You focus your studies on magic that dazzles the senses, befuddles the mind, and tricks even the wisest folk.', 'source' => 'PHB 2024'],
    ];

    public function run(): void
    {
        foreach ($this->subclasses as $subclassData) {
            $classSlug = $subclassData['class_slug'];
            unset($subclassData['class_slug']);

            $class = CharacterClass::where('slug', $classSlug)->first();

            if ($class !== null) {
                Subclass::updateOrCreate(
                    ['slug' => $subclassData['slug']],
                    array_merge($subclassData, [
                        'class_id' => $class->id,
                    ])
                );
            }
        }
    }
}
