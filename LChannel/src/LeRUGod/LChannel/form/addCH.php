<?php


namespace LeRUGod\LChannel\form;

use pocketmine\form\Form;
use pocketmine\Player;
use LeRUGod\LChannel\LChannel;
use pocketmine\Server;

class addCH implements Form {

    protected $sy = "§b§l[ §f시스템 §b]§r ";

    public function jsonSerialize() {

        $arr = [
                [
                        'type' => 'input',
                        'text' => '채널 이름을 입력해주세요',
                        'placeholder' => 'ex)1채널'
                ],
                [
                        'type' => 'input',
                        'text' => '채널을 만들 월드를 선택해주세요',
                        'placeholder' => '월드 이름을 정확히 입력해주세요!'
                ],
                [
                        'type' => 'dropdown',
                        'text' => '채널을 만들 버튼을 선택해주세요',
                        'options' => ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20']
                ],
                [
                        'type' => 'input',
                        'text' => '이동할 X좌표를 입력해주세요',
                        'placeholder' => '좌표를 하나라도 입력 안할시 스폰으로 이동됩니다'
                ],
                [
                        'type' => 'input',
                        'text' => '이동할 Y좌표를 입력해주세요',
                        'placeholder' => '좌표를 하나라도 입력 안할시 스폰으로 이동됩니다'
                ],
                [
                        'type' => 'input',
                        'text' => '이동할 Z좌표를 입력해주세요',
                        'placeholder' => '좌표를 하나라도 입력 안할시 스폰으로 이동됩니다'
                ],

        ];

        return [
            'type' => 'custom_form',
            'title' => '§l§f채널 추가',
            'content' => $arr
        ];
    }

    public function handleResponse(Player $player, $data): void {

        if ($data === null)return;
        if ($data[0] === null){

            $player->sendMessage($this->sy."§l§f채널 이름을 입력해주세요!");
            return;

        }elseif ($data[1] === null){

            $player->sendMessage($this->sy."§l§f월드 이름을 입력해주세요!");
            return;

        }elseif ($data[2] === null) {

            $player->sendMessage($this->sy . "§l§f채널을 몇번쨰 버튼에 오게 할 지 입력해주세요");
            return;

        }elseif (Server::getInstance()->loadLevel($data[1]) == false){

            $player->sendMessage($this->sy."§l§f월드가 월드 폴더 안에 존재하지 않습니다!");
            return;

        } elseif (LChannel::getInstance()->getLevel($data[1]) === null){

            $player->sendMessage($this->sy."§l§f월드가 월드 폴더 안에 존재하지 않습니다!");
            return;

        }else{

            $button = $data[2] + 1;

            LChannel::getInstance()->addChannel($data[0],$data[1],$data[3],$data[4],$data[5],$button);
            LChannel::getInstance()->onSave();

            $player->sendMessage($this->sy."§l§f채널이 성공적으로 지정되었습니다!");

            return;


        }

    }

}