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

namespace Britt\DeathSwap\commands;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;
use Britt\DeathSwap\Main;
use Britt\DeathSwap\Task\CountDown;
use Britt\DeathSwap\Task\Swap;

class DeathSwapCommand extends PluginCommand
{
    private $main;

    public function __construct(Main $main)
    {
        parent::__construct("deathswap", $main);
        $this->setMain($main);
        $this->setAliases(["ds"]);
        $this->setDescription("DeathSwap command");
    }

    public function getMain(): Main
    {
        return $this->main;
    }

    public function setMain(Main $main)
    {
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) 
    {
        if(!$sender->hasPermission("ds.cmd"))
        {
            $sender->sendMessage(TF::RED . "You do not have the node ds.cmd permissions!");
         }else{
            switch ($args[0] ?? "help") 
            {
                case "help";
                {
                    $red = TF::YELLOW;
                    $lines = TF::AQUA . "--------------------------------------------------------";
                    $sender->sendMessage($lines . "\n" . $red . "/deathswap about - General info about the plugin \n" . $red . "/deathswap start - Starts the Game\n" . $red . "/deathswap help - Lists all the Deathswap commands \n" . $lines);
                    return true;
                    break;
                }
                case "info"; 
                {
                    $red = TF::GREEN;
                    $lines = TF::AQUA . "--------------------------------------------------------";
                    $sender->sendMessage($lines . "\n" . $red . "Welcome to DeathSwap \n" . $red . "This Plugin was made by GoodBritt14 aka HydroGames\n" . $red . "Just use /deathswap start to start the minigame \n" . $lines);
                    return true;
                    break;
                }
                case "start"; 
                {
                    $onlinePlayers = count($sender->getServer()->getOnlinePlayers());
                    if($onlinePlayers != 2) 
                    {
                        $sender->sendMessage("§e[§l§cDeath§bSwap§r§e] §aYou need 2 players to play this");
                    }else{
                        $this->getMain()->setGame(true);
                        $this->getMain()->getScheduler()->scheduleRepeatingTask(new CountDown($this->getMain()), 20);
                        $this->getMain()->getScheduler()->scheduleRepeatingTask(new Swap($this->getMain()), 20);
                    }
                }
            }
            return true;
        }
        return true;
    }
}