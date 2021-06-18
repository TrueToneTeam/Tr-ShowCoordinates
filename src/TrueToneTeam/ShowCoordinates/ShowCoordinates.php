<?php

namespace TrueToneTeam\ShowCoordinates;

use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;

class ShowCoordinates extends PluginBase implements Listener{
	
	private static $instance = null;
	
	public static function getInstance(): self{
		return self::$instance;
	}
	
	public function onLoad(){
		if (self::$instance !== null){
			throw new \InvalidStateException();
		}
		self::$instance = $this;
	}
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		
		$packet = new GameRulesChangedPacket();
		$packet->gameRules = [
			"showcoordinates" => [1, true, true]
		];
		$player->sendDataPacket($packet);
	}
}