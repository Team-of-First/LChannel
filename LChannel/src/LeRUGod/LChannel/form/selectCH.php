<?php


namespace LeRUGod\LChannel\form;


use LeRUGod\LChannel\LChannel;
use pocketmine\form\Form;
use pocketmine\Player;

class selectCH implements Form {

    public function jsonSerialize() {

        $arr = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'];

        $nms = [];

        foreach ($arr as $num){

            if (!isset(LChannel::getInstance()->db['CH'][$num]['world'])){
                array_push($nms,array('text' => '§lEMPTY CHANNEL'));
            }else{
                array_push($nms,array('text' => LChannel::getInstance()->db['CH'][$num]['name']."\n§r온라인 플레이어 : ".LChannel::getInstance()->getWRplayers(LChannel::getInstance()->getLevel(LChannel::getInstance()->db['CH'][$num]['world']))));
            }

        }

        return [
            'type' => 'form',
            'title' => '§l§f채널 이동',
            'content' => '',
            'buttons' => $nms
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null)return;
        if ($data === 0){
            LChannel::getInstance()->tpbyCH($player,1);
        }elseif ($data === 1){
            LChannel::getInstance()->tpbyCH($player,2);
        }elseif ($data === 2){
            LChannel::getInstance()->tpbyCH($player,3);
        }elseif ($data === 3){
            LChannel::getInstance()->tpbyCH($player,4);
        }elseif ($data === 4){
            LChannel::getInstance()->tpbyCH($player,5);
        }elseif ($data === 5){
            LChannel::getInstance()->tpbyCH($player,6);
        }elseif ($data === 6){
            LChannel::getInstance()->tpbyCH($player,7);
        }elseif ($data === 7){
            LChannel::getInstance()->tpbyCH($player,8);
        }elseif ($data === 8){
            LChannel::getInstance()->tpbyCH($player,9);
        }elseif ($data === 9){
            LChannel::getInstance()->tpbyCH($player,10);
        }elseif ($data === 10){
            LChannel::getInstance()->tpbyCH($player,11);
        }elseif ($data === 11){
            LChannel::getInstance()->tpbyCH($player,12);
        }elseif ($data === 12){
            LChannel::getInstance()->tpbyCH($player,13);
        }elseif ($data === 13){
            LChannel::getInstance()->tpbyCH($player,14);
        }elseif ($data === 14){
            LChannel::getInstance()->tpbyCH($player,15);
        }elseif ($data === 15){
            LChannel::getInstance()->tpbyCH($player,16);
        }elseif ($data === 16){
            LChannel::getInstance()->tpbyCH($player,17);
        }elseif ($data === 17){
            LChannel::getInstance()->tpbyCH($player,18);
        }elseif ($data === 18){
            LChannel::getInstance()->tpbyCH($player,19);
        }elseif ($data === 19){
            LChannel::getInstance()->tpbyCH($player,20);
        }
    }

}