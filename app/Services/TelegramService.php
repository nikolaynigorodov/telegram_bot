<?php


namespace App\Services;


use App\Models\Telegram;
use Telegram\Bot\Objects\Message;

class TelegramService
{
    public function saveAndReturnName($messages)
    {
        $user = $messages->from;
        $user_id = $user->id;
        $user_name = $user->first_name;

        $search = Telegram::where('telegram_user_id', '=', $user_id)->first();

        if(!$search) {
            $model = new Telegram();
            $model->telegram_user_id = $user_id;
            $model->telegram_user_name = $user_name;
            $model->save();
        }

        return $user_name;
    }

    public function getAllInformation()
    {
        $models = Telegram::with('trellos')->get();
        $text = "";
        foreach ($models as $model) {
            $countDesc = $model->trellos->count();
            $text .= $model->telegram_user_name;
            $trelloUserName = '';
            $desc = '';
            if($model->trello_user_name) {
                $trelloUserName = $model->trello_user_name;
            }
            if($countDesc != 0) {
                foreach ($model->trellos as $trello) {
                    $desc .= $trello->card_name . PHP_EOL;
                }
            }
            $text .= !empty($trelloUserName) ? "($trelloUserName) " : "";
            $text .= "has " . $countDesc . " tasks" . PHP_EOL;
            if(!empty($desc)) {
                $text .= $desc;
            }
        }

        return $text;
    }
}
