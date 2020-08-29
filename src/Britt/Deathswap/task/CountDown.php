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

namespace Britt\DeathSwap\task;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\event\HandlerList;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as TF;
use Britt\DeathSwap\Main;
use Britt\DeathSwap\Task\Swap;

class CountDown extends Task 
{
    public $timer = 11;
    
    public $main;
    
        public function __construct(Main $main) 
        {
            $this->main = $main;
        }
        public function onRun(int $currentTick) 
        {
            $this->timer--;
            foreach($this->main->getServer()->getOnlinePlayers() as $players) 
            {
                $players->sendTip(TF::RED . "DeathSwap starts in " . $this->timer, TF::GREEN . "Get ready to swap!");
                if($this->timer <= 1) 
                {
                    $x = mt_rand(0, 300);
                    $y = 89;
                    $z = mt_rand(0, 400);
                    $steak = Item::get(Item::COOKED_BEEF)->setCount(32);
                    $bucket = Item::get(Item::BUCKET)->setCount(1);
                    $dur = Item::get(Item::DIAMOND_PICKAXE)->setCount(1)->setDamage(4);
                    $players->getInventory()->clearAll();
                    $players->getArmorInventory()->clearAll();
                    $players->getInventory()->setItem(8, $steak);
                    $players->getInventory()->setItem(7, $bucket);
                    $players->getInventory()->setItem(6, $dur);
                    $players->setGamemode(0);
                    $players->setHealth(20);
                    $players->setFood(20);
                    $players->teleport(new Vector3($x, $y, $z));
                    $players->addEffect(new EffectInstance(Effect::getEffect(15), 550, 100));
                    $players->addEffect(new EffectInstance(Effect::getEffect(12), 450, 100));
                    $players->addEffect(new EffectInstance(Effect::getEffect(24), 550, 200));
                    $players->addEffect(new EffectInstance(Effect::getEffect(11), 550, 100));
                    $this->main->getScheduler()->cancelTask($this->getTaskId());
                }
            }
        }
      }
