<?php


namespace App\Services;


use App\Models\Telegram;
use App\Models\Trello;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class TrelloServices
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function saveUserTrello($data, $telegram_id)
    {
        $text = '';
        $checkRegister = Telegram::where('telegram_user_id', '=', $telegram_id)
            ->where('trello_user_id', "=", $data->id)
            ->first();
        if($checkRegister) {
            $text = "You are already registered";
        } else {
            $model = Telegram::where('telegram_user_id', '=', $telegram_id)->first();
            if($model) {
                $model->trello_user_id = $data->id;
                $model->trello_user_name = $data->fullName;
                $model->save();

                $text = "Your account $data->fullName has been successfully linked to telegram";
            } else {
                $text = "Your data is not on the server, you did not take the /start command";
            }
        }

        return $text;
    }

    public function setUserToCard($data)
    {
        if(isset($data['action']['data']['idMember'])) {
            $trelloUserId = $data['action']['data']['idMember'];
            $trelloCardId = $data['action']['data']['card']['id'];
            $trelloCardName = $data['action']['data']['card']['name'];

            $telegramUser = $this->getUser($trelloUserId);
            if($telegramUser) {
                $this->deleteCard($telegramUser->id, $trelloCardId);
                $trello = new Trello();
                $trello->telegram_id = $telegramUser->id;
                $trello->card_id = $trelloCardId;
                $trello->card_name = $trelloCardName;
                $trello->save();
                return "For the telegram user name \"$telegramUser->telegram_user_name\", Trello user name \"$telegramUser->trello_user_name\" add in card name \"$trelloCardName\"";
            }
        }
        return "";
    }

    public function deleteUserFromCard($data)
    {
        if(isset($data['action']['data']['idMember'])) {
            $trelloUserId = $data['action']['data']['idMember'];
            $trelloCardId = $data['action']['data']['card']['id'];
            $trelloCardName = $data['action']['data']['card']['name'];

            $telegramUser = $this->getUser($trelloUserId);
            if($telegramUser) {
                $this->deleteCard($telegramUser->id, $trelloCardId);
                return "Left card \"$trelloCardName\", user name \"$telegramUser->telegram_user_name\", Trello user name \"$telegramUser->trello_user_name\" ";
            }
        }
        return "";
    }

    protected function getUser(string $trelloId)
    {
        return Telegram::where('trello_user_id', '=' , $trelloId)->first();
    }

    protected function deleteCard(int $userId, string $trelloCardId)
    {
        Trello::where('telegram_id', "=", $userId)->where('card_id', "=", $trelloCardId)->delete();
    }
}
