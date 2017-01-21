<?php

#Plugin original par FRISCOWS. 

namespace SmarTechMCPE;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\entity\Effect;
use pocketmine\block\IronOre;
use pocketmine\block\GoldOre;
use pocketmine\block\Sand;
use pocketmine\block\Gravel;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\level\Position;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\command\Command;
use pocketmine\level\Level;
use pocketmine\scheduler\CallbackTask;
use pocketmine\scheduler\PluginTask;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;


class Main extends PluginBase implements Listener {
public $pvp;
    public $prefix = TextFormat::DARK_GRAY . "[" . TextFormat::RED . "§bUHC" . TextFormat::DARK_GRAY . "] " . TextFormat::GRAY;
    public $globalmute = false;
    public $spam = [];
   public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "Cord")), 0);
    		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "Alive")), 20 * 60);
    		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "msg")), 20 * 120);
    $this->pvp = FALSE;
   }
	public function Cord(){
	foreach($this->getServer()->getOnlinePlayers() as $player){
	if($player->getInventory()->getItemInHand()->getId() == "345") {
	$x = $player->getFloorX();
	$y = $player->getFloorY();
	$z = $player->getFloorZ();
 	$player->sendPopup("§3X: §7$x §3Y: §7$y §3Z: §7$z");
}
}
}
public function Alive (){
	foreach($this->getServer()->getOnlinePlayers() as $p){
		$p->sendTip($this->prefix .  "§7 Bon jeu ! Sois le dernier survivant ! ");
	}	
}
public function msg (){

 foreach($this->getServer()->getOnlinePlayers() as $p){

$p->sendMessage($this->prefix . "Pour organiser un UHC, suis-nous sur Twitter ; §b@§6PureUHC_PE");
}
}
  	
  public function onBreak(BlockBreakEvent $event) {
    if($event->getBlock()->getId() == 15) {
      $drops = array(Item::get(265, 0, 2));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 17) {
      $drops = array(Item::get(5, 0, 4));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 14) {
      $drops = array(Item::get(266, 0, 3));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 18) {
      $drops = array(Item::get(260, 0, 1));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 56) {
      $drops = array(Item::get(264, 0, 1));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 83) {
      $drops = array(Item::get(116, 0, 1));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 16) {
      $drops = array(Item::get(50, 0, 4));
      $event->setDrops($drops);
    }
  }
public function onJoin(PlayerJoinEvent $event){
$player = $event->getPlayer();
$name = $player->getName();
$this->getServer()->broadcastPopup("§b[§a+§b]§6 ".$event->getPlayer()->getName()." à rejoint la partie.");
$event->setJoinMessage("");
}
public function onQuit(PlayerQuitEvent $event){
$player = $event->getPlayer();
$name = $player->getName();
$this->getServer()->broadcastPopup("§b[§c-§b]§6 ".$event->getPlayer()->getName()." à quitté la partie.");
$event->setQuitMessage("");
}
public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {

	$cmd = strtolower($cmd->getName());
$players = $sender->getName();
	switch($cmd){
case 'uhc':
if ($sender->isOp()){
switch($args[0]){

case "reset":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->setMaxHealth(20);
$p->setHealth(20);
$p->setFood(20);
$p->setGamemode(0);
$p->getInventory()->clearAll();
$p->removeAllEffects();
}
$this->getServer()->broadcastMessage(" §7L'UHC à été réinitialisé !");
return true;
break;

case "help":
$sender->sendMessage("§6-+={§bUHC SCENARIOS§6}=+-");
$sender->sendMessage("§b/uhc reset: §7Réinitialiser l'UHC !");
$sender->sendMessage("§b/uhc meetup: §7Obtenir le kit meetup");
$sender->sendMessage("§b/uhc start: §7 Démarrer la partie");
$sender->sendMessage("§b/uhc tpall: §7Téléporter tout le monde à toi");
$sender->sendMessage("§b/uhc food: §7Donner 64 steaks à tout le monde !");
$sender->sendMessage("§b/uhc pvp <on/off>: §7Activer ou désactiver le PvP !");
$sender->sendMessage("§b/uhc scenario <scenario>: §7Séléctionner un scénario ! (Un seul par partie)");
$sender->sendMessage("§b/uhc scenarios : §7Avoir la liste des scénarios ! (Proposes-nous en sur http://smrtk.tk/stuhc )");

$sender->sendMessage("§b/uhc globalmute: §7Interdire le chat à tout les jours non OPs ou Host !");
return true;
break;
case "pvp":
if($args[1] == "on"){
 $this->pvp = TRUE;
 $this->getServer()->broadcastMessage("§7PvP activé !");
 
   
 }

 If($args[1] == "off"){
$this->pvp = FALSE;
 $this->getServer()->broadcastMessage("§7PvP désactivé !");
}
return true;
break;

case "scenario":
if($args[1] == "superheros"){
 $this->getServer()->broadcastMessage("§7Le scénario choisi est : §bSuperHeros§7 !");
 $this->getServer()->broadcastMessage("§7Tu as reçu un effet au hasard ! Tu le gardera toute la partie !");
 foreach($this->getServer()->getOnlinePlayers() as $p){
 	           $kit = rand(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
 	           $speed = Effect::getEffect($kit);
                    $speed->setAmplifier(2);
                    $speed->setVisible(false);
                    $speed->setDuration(1000000);
                    $p->addEffect($speed);
   }
 }

if($args[1] == "invisible"){
 $this->getServer()->broadcastMessage("§7Le scénario choisi est :§b Invisible §7!");
 $this->getServer()->broadcastMessage("§7Tu es invisible ! Amuse-toi à PvP en étant invisible ! Tu verras, c'est dur !");
 foreach($this->getServer()->getOnlinePlayers() as $p){
 	           $invisibility = Effect::getEffect(14);
                    $invisibility->setAmplifier(1);
                    $invisibility->setVisible(true);
                    $invisibility->setDuration(1000000);
                    $p->addEffect($invisibility);
   }
 }
return true;
break;

 case "meetup":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->getInventory()->clearAll();
$p->getInventory()->addItem(Item::get(276, 0, 1));
$p->getInventory()->addItem(Item::get(ITEM::GOLDEN_APPLE, 0, 6));
$p->getInventory()->addItem(Item::get(ITEM::GOLDEN_APPLE, 0, 3));
$p->getInventory()->addItem(Item::get(257, 0, 1));
$p->getInventory()->addItem(Item::get(345, 0, 1));
$p->getInventory()->addItem(Item::get(364, 0, 64));
$p->getInventory()->addItem(Item::get(ITEM::BOW, 0, 1));
$p->getInventory()->addItem(Item::get(ITEM::ARROW, 0, 32));
$p->getInventory()->addItem(Item::get(346, 0, 1));

$p->getInventory()->setHelmet(Item::get(310, 0, 1));
$p->getInventory()->setChestplate(Item::get(311, 0, 1));
$p->getInventory()->setLeggings(Item::get(312, 0, 1));
$p->getInventory()->setBoots(Item::get(313, 0, 1));
$p->getInventory()->sendArmorContents($p);
}	            
$this->getServer()->broadcastMessage("§7Tu as reçu le kit meetup !");
return true;
break;


case "start":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->getInventory()->clearAll();

$p->getInventory()->addItem(Item::get(257, 0, 1));
$p->getInventory()->addItem(Item::get(364, 0, 64));
$p->getInventory()->addItem(Item::get(50, 0, 16));
$p->getInventory()->addItem(Item::get(345, 0, 1));


$p->getInventory()->setBoots(Item::get(301, 0, 1));
$p->getInventory()->sendArmorContents($player);
}	            

$this->getServer()->broadcastMessage("§7L'UHC commence dans 10 secondes...");
Sleep(10);
$this->getServer()->broadcastMessage(" §7L'UHC à commencé !");
return true;
break;


case "scenarios":
$sender->sendMessage("§9-+={§6Scenarios disponibles§9}=+-");
$sender->sendMessage("§5Proposes-nous en sur http://smrtk.tk/stuhc");
$sender->sendMessage("§9>>§b SuperHeros :§7 donne un effet au hasard à tout le monde");
$sender->sendMessage("§9>>§b Invisible :§7 rend tout le monde invisible (il y a quand même les particules)");
return true;
break;


case "huball":
foreach($this->plugin->getServer()->getOnlinePlayers() as $p) {
$p->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
$this->getServer()->broadcastMessage(" §7Vous avez été téléporté au lobby.");
}


case "food":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->getInventory()->addItem(Item::get(364, 0, 64));
$this->getServer()->broadcastMessage(" §7Tu as reçu de la nourriture !");
}
return true;
break;
///GlobalMute///

            case "globalmute":
                if ($sender->hasPermission("UHC.host")) {
                    if ($this->globalmute === false) {
                        $this->getServer()->broadcastMessage($this->prefix . TextFormat::GRAY . "Le GlobalMute est activé! Seuls les OPs et les Host peuvent parler dans le chat !");
                        $this->globalmute = true;
                        return true;
                    } else {
                        $this->getServer()->broadcastMessage($this->prefix . TextFormat::GRAY . "Le GlobalMute est désactivé. Tu peux à nouveau parler dans le chat.");
                        $this->globalmute = false;
                        return true;
                    }
                }


case "tpall":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->teleport(new Vector3($sender->x, $sender->y, $sender->z));
$this->getServer()->broadcastMessage(" §7Téléportation...");
}
return true;
break;

}
}else{
	$sender->sendMessage("§cVous n'avez pas la permission d'utiliser cette commande. Vous devez être OP ou Host.");
}
return true;
break;

}
}
    public function onPlayerDeath(PlayerDeathEvent $event)
    {
        $player = $event->getPlayer();
        $player->setGamemode(3);
        if ($player instanceof Player) {
            $cause = $player->getLastDamageCause();
            if ($cause instanceof EntityDamageByEntityEvent) {
                $killer = $cause->getDamager();
                $killer->setHealth($killer->getHealth() + 10);
                $killer->sendMessage("Tu as gagné  §c10 <3 §7de vie pour avoir tuer quelqu'un.");
                $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " a été tué par " . $killer->getName() . ".");
            } else {
                $cause = $player->getLastDamageCause()->getCause();
                if($cause === EntityDamageEvent::CAUSE_SUFFOCATION)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " a suffoqué dans un mur.");
                } elseif ($cause === EntityDamageEvent::CAUSE_DROWNING)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " s'est noyé.");
                } elseif ($cause === EntityDamageEvent::CAUSE_FALL)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " a fait une trop grosse chute.");
                } elseif ($cause === EntityDamageEvent::CAUSE_FIRE)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " à brulé.");
                } elseif ($cause === EntityDamageEvent::CAUSE_FIRE_TICK)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " a brulé.");
                } elseif ($cause === EntityDamageEvent::CAUSE_LAVA)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " a essayé de nager dans la lave.");
                } elseif ($cause === EntityDamageEvent::CAUSE_BLOCK_EXPLOSION)
                {
                    $eve
