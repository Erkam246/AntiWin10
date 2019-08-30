<?php

namespace ErkamKahriman\AntiWin10;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class AntiWin10 extends PluginBase implements Listener {
    public $kickmessage;

    public function onEnable(){
        $config = $this->getConfig();
        $config->setDefaults(
            [
                "kick-msg" => "§fWindows 10 §7players are not §callowed!"
            ]
        );
        $config->save();
        $this->kickmessage = $config->get("kick-msg", "§fWindows 10 §7players are not §callowed!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function DataPacketReceive(DataPacketReceiveEvent $event){
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        if($packet instanceof LoginPacket){
            if(!isset($packet->clientData["DeviceOS"])) return;
            if((int)$packet->clientData["DeviceOS"] === 7){
                $player->kick($this->kickmessage, false);
            }
        }
    }
}