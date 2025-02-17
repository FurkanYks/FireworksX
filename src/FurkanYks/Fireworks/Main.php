<?php

namespace FurkanYks\Fireworks;

use pocketmine\entity\{EntityFactory, EntityDataHelper};

use pocketmine\item\{ArmorTypeInfo, ItemIdentifier, Item, StringToItemParser};
use pocketmine\inventory\{ArmorInventory, CreativeInventory};

use pocketmine\data\bedrock\item\ItemTypeNames;
use pocketmine\data\bedrock\item\SavedItemData;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\format\io\GlobalItemDataHandlers;
use pocketmine\world\World;
use pocketmine\plugin\PluginBase;

use FurkanYks\Fireworks\Event\MoveEvent;

class Main extends PluginBase
{
    
    public function onEnable(): void
    {

        $itemDeserializer = GlobalItemDataHandlers::getDeserializer();
        $itemSerializer = GlobalItemDataHandlers::getSerializer();
        $stringToItemParser = StringToItemParser::getInstance();
        $creativeInventory = CreativeInventory::getInstance();

        $fireworks = ExtraVanillaItems::FIREWORKS();
        $itemDeserializer->map(ItemTypeNames::FIREWORK_ROCKET, static fn() => clone $fireworks);
        $itemSerializer->map($fireworks, static fn() => new SavedItemData(ItemTypeNames::FIREWORK_ROCKET));
        $stringToItemParser->register("firework_rocket", static fn() => clone $fireworks);

        $elytra = ExtraVanillaItems::ELYTRA();
        $itemDeserializer->map(ItemTypeNames::ELYTRA, static fn() => clone $elytra);
        $itemSerializer->map($elytra, static fn() => new SavedItemData(ItemTypeNames::ELYTRA));
        $creativeInventory->add($elytra);
        $stringToItemParser->register('elytra', static fn() => clone $elytra);

        EntityFactory::getInstance()->register(FireworksRocket::class, static function (World $world, CompoundTag $nbt): FireworksRocket {
            return new FireworksRocket(EntityDataHelper::parseLocation($nbt, $world), Item::nbtDeserialize($nbt->getCompoundTag("Item")));
        }, ["FireworksRocket", EntityIds::FIREWORKS_ROCKET]);
        
        $this->getServer()->getPluginManager()->registerEvents(new MoveEvent(), $this);
    }
}