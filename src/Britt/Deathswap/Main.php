<?php
/** DeathSwap  Copyright (C) 2019-2021 HydroGames Team
 * HydroGamesTeam - Plugin
 *
 * Copyright (C) HydroGamesTeam
 *
 * @author Britt
 *        
*/
declare(strict_types=1);

namespace Britt\DeathSwap;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use Britt\DeathSwap\commands\DeathSwapCommand;
use Britt\DeathSwap\task\Swap;
use Britt\DeathSwap\task\CountDown;
use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase  implements Listener 
{
    public $game = false;
    
    public function onEnable()
    {
        $this->getLogger()->info("§aDeathSwap has been enabled!");
        $this->getLogger()->info("§aDeathSwap Made by Britt");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->registerAll("command", [
            new DeathSwapCommand($this),
            ]);
    }
    public function onDisable()
    {
        $this->getLogger()->info("Disabling & Saving Files for DeathSwap...");
    }
    public function isGame() : bool 
    {
        return $this->game;
    }
    public  function setGame(bool $game) 
    {
        $this->game = $game;
    }
    public function onJoin(PlayerJoinEvent $event)
    {
		$player = $event->getPlayer();
		$playerName = $player->getName();
		$player->getInventory()->setItem(4, Item::get(Item::IRON_INGOT)->setCustomName(TF::RESET . "§bTip - Fill the buckets to mlg or to drown urself"));
		$event->setJoinMessage(TextFormat::YELLOW . TextFormat::BOLD . $playerName . "Welcome to DeathSwap!");
	    $player->getInventory()->setItem(5, Item::get(Item::NETHERSTAR)->setCustomName(TF::RESET . "§aAlso no repeating the same traps"));
    }
    
    public function onDeath(PlayerDeathEvent $event)  
    {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        if ($this->isGame() === true) 
        {
            foreach ($this->getServer()->getOnlinePlayers() as $players) 
            {
                $players->sendMessage(TextFormat::GREEN . TextFormat::BOLD . $playerName . " Has lost the game! | Reason: Death");
                $this->getScheduler()->cancelAllTasks();
                $this->setGame(false);
            }
        }
    }
    public function onQuit(PlayerQuitEvent $event) : void 
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        if ($this->isGame() === true) 
        {
            foreach ($this->getServer()->getOnlinePlayers() as $players) 
            {
                $players->sendMessage(TextFormat::GREEN . TextFormat::BOLD . $name . " has lost the game! | Reason: Quit Game");
                $this->getScheduler()->cancelAllTasks();
                $this->setGame(false);
            }
         }else{
            return;
        }
    }
}
