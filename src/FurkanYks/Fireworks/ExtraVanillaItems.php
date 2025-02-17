<?php

namespace FurkanYks\Fireworks;

use FurkanYks\Fireworks\Fireworks;
use FurkanYks\Fireworks\Item\Elytra;
use pocketmine\inventory\ArmorInventory;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\utils\CloningRegistryTrait;

class ExtraVanillaItems{
    use CloningRegistryTrait;

    private function __construct(){
    }

    /**
     * @param string $name
     * @param Item $item
     * @return void
     */
    protected static function register(string $name, Item $item) : void{
        self::_registryRegister($name, $item);
    }

    /**
     * @return Item[]
     */
    public static function getAll() : array{
        /** @var Item[] $result */
        $result = self::_registryGetAll();
        return $result;
    }

    /**
     * @return void
     */
    protected static function setup(): void{
        self::register('fireworks', new Fireworks(new ItemIdentifier(ItemTypeIds::newId()), 'Fireworks'));
        self::register('elytra', new Elytra(new ItemIdentifier(ItemTypeIds::newId()), 'Elytra', new ArmorTypeInfo(0, 433, ArmorInventory::SLOT_CHEST)));
    }
}