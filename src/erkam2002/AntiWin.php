<?php

namespace erkam2002;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

class AntiWin extends PluginBase implements Listener {

    public $config;

    public function onEnable(){
        $this->saveResource("config.yml");
        @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML, [
           "kick-msg" => "You`r playing on Windows 10"
        ]);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Aktiviert.");
    }

    public function onPreLogin(PlayerPreLoginEvent $event){
        $player = $event->getPlayer();
        if($player->getDeviceOS() == 7){
            $player->kick($this->config->get("kick-msg"), false);
        }
    }

    public function onDisable(){
        $this->getLogger()->info("Deaktiviert.");
    }
}