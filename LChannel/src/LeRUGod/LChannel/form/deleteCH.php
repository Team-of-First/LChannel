<?php


namespace LeRUGod\LChannel\form;


use LeRUGod\LChannel\LChannel;
use pocketmine\form\Form;
use pocketmine\Player;

class deleteCH implements Form {

    protected $sy = "§b§l[ §f시스템 §b]§r ";

    public function jsonSerialize() {

        $arr = [[
            'type' => 'dropdown',
            'text' => '초기화할 버튼을 선택해주세요',
            'options' => ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20']
        ]];

        return [
            'type' => 'custom_form',
            'title' => '§l§f채널 삭제',
            'content' => $arr
        ];
    }

    public function handleResponse(Player $player, $data): void {
        if ($data === null)return;
        if ($data[0] === null)return;

        $button = $data[0] + 1;
        LChannel::getInstance()->resetCH($button);
        $player->sendMessage($this->sy.'§l§f'.$button.' 번 채널이 성공적으로 삭제되었습니다!');

    }
}