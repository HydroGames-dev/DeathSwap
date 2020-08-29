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

namespace Britt\DeathSwap\Task;

use pocketmine\math\Vector3;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\event\HandlerList;
use jackmd\scorefactory\ScoreFactory;
use pocketmine\event\Listener;
use pocketmine\Player;
use Britt\DeathSwap\Main;
use Britt\DeathSwap\CountDown;
use pocketmine\utils\TextFormat as TF;

class Swap extends Task 
{
    public $timer2 = 312;
    
    public $main;
    
    public function __construct(Main $main) 
    {
        $this->main = $main;
    }
    
    public function onRun(int $currentTick) 
    {
        $playerArray = $this->main->getServer()->getOnlinePlayers();
        $firstPlayer = current($playerArray);
        $secondPlayer = next($playerArray);
        $this->timer2--;
                if($this->timer2 === 240) 
                {
                    $firstPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 4 minutes!");
                    $secondPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 4 minutes!");
                }
                if($this->timer2 === 180) 
                {
                    $firstPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 3 minutes!");
                    $secondPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 3 minutes!");
                }
                if($this->timer2 === 120) 
                {
                    $firstPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 2 minutes!");
                    $secondPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 2 minutes!");
                }
                if($this->timer2 === 60) 
                {
                    $firstPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 1 minute!");
                    $secondPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in 1 minutes!");
                }
                if($this->timer2 <= 10) 
                {
                    $firstPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in " . $this->timer2 . " seconds!");
                    $secondPlayer->sendMessage(TF::RED . TF::BOLD . "Swapping in " . $this->timer2 . " seconds!");
                }
                if($this->timer2 <= 1) 
                {
                    $firstPlayer->sendMessage(TF::AQUA . TF::BOLD . "Swapped! with" . $secondPlayer->getName() . "!");
                    $secondPlayer->sendMessage(TF::AQUA . TF::BOLD . "Swapped! with" . $firstPlayer->getName() . "!");
                    $fX = $firstPlayer->getX();
                    $fY = $firstPlayer->getY();
                    $fZ = $firstPlayer->getZ();
                    $sX = $secondPlayer->getX();
                    $sY = $secondPlayer->getY();
                    $sZ = $secondPlayer->getZ();
                    $firstPlayer->teleport(new Vector3($sX, $sY, $sZ));
                    $secondPlayer->teleport(new Vector3($fX, $fY, $fZ));
                    $this->timer2 = 312;
                    $this->timer2--;
      }
    }
    private function handleScoreboard(Player $p): void{
        ScoreFactory::setScore($p, "§cDeath §bSwap§e!");
        if($this->isGame() === true) {
        	ScoreFactory::setScoreLine($p, 1, " §6Hello, §b" . $p->getDisplayName());
			ScoreFactory::setScoreLine($p, 2, " §e-------------- ");
			ScoreFactory::setScoreLine($p, 3, " §aSwapping in" . $this->timer2 . ($this->timer2 >= 60 ? " §aMinutes!" : " §bSeconds!"));
			ScoreFactory::setScoreLine($p, 4, " §e-------------- ");
			ScoreFactory::setScoreLine($p, 5, " §6Have Fun");
        } else{
        	ScoreFactory::setScoreLine($p, 1, " §6Hello, §b" . $p->getDisplayName());
            ScoreFactory::setScoreLine($p, 2, " §e-------------- ");
			ScoreFactory::setScoreLine($p, 3, " §6Welcome to");
			ScoreFactory::setScoreLine($p, 4, " §cDeath §bSwap");
			ScoreFactory::setScoreLine($p, 5, " §e-------------- ");
			ScoreFactory::setScoreLine($p, 6, " §6Have Fun");          
        }
    }
  }