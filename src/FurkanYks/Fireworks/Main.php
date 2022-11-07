<?php

namespace FurkanYks\Fireworks;

use FurkanYks\Fireworks\Item\Elytra;
use pocketmine\entity\{EntityFactory, EntityDataHelper};

use pocketmine\item\{ArmorTypeInfo, ItemIdentifier, Item, ItemIds, ItemFactory, StringToItemParser};
use pocketmine\inventory\{ArmorInventory, CreativeInventory};

use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\data\bedrock\EntityLegacyIds;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;
use pocketmine\plugin\PluginBase;

use FurkanYks\Fireworks\Event\MoveEvent;

class Main extends PluginBase
{
    
    public function onEnable(): void
    {
        $elytra = new Elytra(new ItemIdentifier(ItemIds::ELYTRA, 0), 'Elytra', new ArmorTypeInfo(0, 433, ArmorInventory::SLOT_CHEST));
        ItemFactory::getInstance()->register($elytra, true);
        StringToItemParser::getInstance()->register('elytra', static fn() => clone $elytra);

        $firework = new Fireworks(new ItemIdentifier(ItemIds::FIREWORKS, 0), "Fireworks Rocket");
        ItemFactory::getInstance()->register($firework, true);
        StringToItemParser::getInstance()->register('fireworks_rocket', static fn() => clone $firework);

        EntityFactory::getInstance()->register(FireworksRocket::class, static function (World $world, CompoundTag $nbt): FireworksRocket{
            return new FireworksRocket(EntityDataHelper::parseLocation($nbt, $world), Item::nbtDeserialize($nbt->getCompoundTag("Item")));
        }, ["FireworksRocket", EntityIds::FIREWORKS_ROCKET], EntityLegacyIds::FIREWORKS_ROCKET);
        
        $this->getServer()->getPluginManager()->registerEvents(new MoveEvent(), $this);
    }
}