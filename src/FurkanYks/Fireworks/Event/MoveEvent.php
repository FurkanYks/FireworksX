<?php

namespace FurkanYks\Fireworks\Event;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;

class MoveEvent implements Listener{

	public const MINIMUM_PITCH = -59;
	public const MAXIMUM_PITCH = 38;
	
	public function onMove(PlayerMoveEvent $event){
		$player = $event->getPlayer();
		if(!$player->isGliding()){
			return;
		}
		if($player->getLocation()->pitch >= self::MINIMUM_PITCH and $player->getLocation()->pitch <= self::MAXIMUM_PITCH){
			$player->resetFallDistance();
		}
	}
}