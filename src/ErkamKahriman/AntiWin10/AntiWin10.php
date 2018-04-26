<?php

namespace ErkamKahriman\AntiWin10;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

class AntiWin10 extends PluginBase implements Listener {

    public function onEnable(){
        @mkdir($this->getDataFolder());
        if (!file_exists($this->getDataFolder()."config.yml")){
            new Config($this->getDataFolder()."config.yml", Config::YAML, [
                "kick-msg" => "§7You are playing on Windows 10§c!"
            ]);
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(C::GREEN."Activated.");
    }

    public function DataPacketReceive(DataPacketReceiveEvent $event){
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        if ($packet instanceof LoginPacket){
            if ($packet->clientData["DeviceOS"] == 7){
                $player->kick($this->getConf("kick-msg"), false);
            }
        }
    }

    private function getConf($get){
        $config = new Config($this->getDataFolder()."config.yml");
        return $config->get($get);
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED."Deactivated.");
    }
}