<?php



namespace LeRUGod\LChannel;

use LeRUGod\LChannel\form\addCH;
use LeRUGod\LChannel\form\deleteCH;
use LeRUGod\LChannel\form\selectCH;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class LChannel extends PluginBase implements Listener {

    public $data;
    public $db;

    private static $instance;

    protected $sy = "§b§l[ §f시스템 §b]§r ";

    public function onEnable() {

        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->addCommand(['채널 추가','채널 선택','채널 삭제','채널 초기화']);
        @mkdir($this->getDataFolder());
        $this->data = new Config($this->getDataFolder()."channels.yml",Config::YAML);
        $this->db = $this->data->getAll();

        if (!isset($this->db['CH']['1'])){

            $but = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'];

            foreach ($but as $button){

                $this->db['CH'][$button]['world'] = null;
                $this->db['CH'][$button]['name'] = null;
                $this->db['CH'][$button]['x'] = null;
                $this->db['CH'][$button]['y'] = null;
                $this->db['CH'][$button]['z'] = null;

            }

            $this->onSave();

        }

    }

    public function addCommand($arr) {

        $commandMap = $this->getServer()->getCommandMap();
        foreach ($arr as $command) {
            $aaa = new PluginCommand($command, $this);
            $aaa->setDescription('채널 추가 커맨드');
            $commandMap->register($command, $aaa);
        }

    }

    public function onSave(){

        $this->data->setAll($this->db);
        $this->data->save();

    }

    public function onLoad() {

        self::$instance = $this;

    }

    public static function getInstance() : self {

        return self::$instance;

    }

    public function getLevel($name){

        if ($name === null)return;

        $level = $this->getServer()->getLevelByName($name);
        if ($level === null){

            return null;

        }else{

            return $level;

        }

    }

    public function addChannel($name,$world,$x,$y,$z,$ch){

        if ($x == null or $y == null or $z == null){

            $x = $this->getServer()->getLevelByName($world)->getSpawnLocation()->getX();
            $y = $this->getServer()->getLevelByName($world)->getSpawnLocation()->getY();
            $z = $this->getServer()->getLevelByName($world)->getSpawnLocation()->getZ();

            $this->db['CH'][$ch]['world'] = $world;
            $this->db['CH'][$ch]['name'] = $name;
            $this->db['CH'][$ch]['x'] = $x;
            $this->db['CH'][$ch]['y'] = $y;
            $this->db['CH'][$ch]['z'] = $z;


            $this->onSave();


        }else{

            $this->db['CH'][$ch]['world'] = $world;
            $this->db['CH'][$ch]['name'] = $name;
            $this->db['CH'][$ch]['x'] = round($x);
            $this->db['CH'][$ch]['y'] = round($y);
            $this->db['CH'][$ch]['z'] = round($z);


            $this->onSave();

        }

    }

    public function tpbyCH(Player $player, int $chnum){

        if ($this->db['CH'][$chnum]['name'] === null){

            $player->sendMessage($this->sy.'§l§f지정되지 않은 채널입니다!');
            return true;

        }

        $x = $this->db['CH'][$chnum]['x'];
        $y = $this->db['CH'][$chnum]['y'];
        $z = $this->db['CH'][$chnum]['z'];

        $world = $this->getServer()->getLevelByName($this->db['CH'][$chnum]['world']);

        $pos = new Position((int)$x,(int)$y,(int)$z,$world);

        $player->teleport($pos,$player->getYaw(),$player->getPitch());
        if ($player->isOp()){

            $player->sendMessage($this->sy.'§l§f'.$chnum.' 번 채널로 이동되었습니다!');
            $player->sendMessage($this->sy.'§l§f채널의 월드 : '.$this->db['CH'][$chnum]['world']);
            $player->sendMessage($this->sy.'§l§f채널의 이름 : '.$this->db['CH'][$chnum]['name']);
            $player->sendMessage($this->sy.'§l§f채널 이동지점의 X, Y, Z 좌표 : [ '.$x.', '.$y.', '.$z.' ]');

        }else{

            $player->sendMessage($this->sy.'§l§f'.$chnum.' 번 채널로 이동되었습니다!');

        }

    }

    public function getWRplayers(Level $level){

        return count($level->getPlayers());

    }

    public function resetCH(int $ch){

        $this->db['CH'][$ch]['world'] = null;
        $this->db['CH'][$ch]['name'] = null;
        $this->db['CH'][$ch]['x'] = null;
        $this->db['CH'][$ch]['y'] = null;
        $this->db['CH'][$ch]['z'] = null;

        $this->onSave();

    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player)return true;
        if ($command->getName() == '채널 추가'){

            if ($sender->isOp()){

                $sender->sendForm(new addCH());

            }else{

                $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                return true;

            }

        }elseif ($command->getName() == '채널 선택'){

            $sender->sendForm(new selectCH());

        }elseif ($command->getName() == '채널 삭제'){

            if ($sender->isOp()){

                $sender->sendForm(new deleteCH());

            }else{

                $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                return true;

            }

        }elseif ($command->getName() == '채널 초기화'){

            if ($sender->isOp()){

                $but = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'];

                foreach ($but as $button){

                    $this->db['CH'][$button]['world'] = null;
                    $this->db['CH'][$button]['name'] = null;
                    $this->db['CH'][$button]['x'] = null;
                    $this->db['CH'][$button]['y'] = null;
                    $this->db['CH'][$button]['z'] = null;

                }

                $this->onSave();

                $sender->sendMessage($this->sy."§l§f채널이 초기화 되었습니다!");

                return true;

            }else{

                $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                return true;

            }

        }

        return false;

    }
}