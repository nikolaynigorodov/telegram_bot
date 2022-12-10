<?php


namespace App\Api;


use App\Models\Telegram;
use App\Services\TrelloServices;
use GuzzleHttp\Client;

class TrelloApi
{
    protected string $text = '';

    private Client $client;
    private TrelloServices $trelloServices;

    public function __construct(Client $client, TrelloServices $trelloServices)
    {
        $this->client = $client;
        $this->trelloServices = $trelloServices;
    }

    public function getUserTrello(string $username, int $telegram_id)
    {
        try {
            $requestUrl = "https://api.trello.com/1/members/" . $username;
            $response = $this->client->get($requestUrl);

            if($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), false);
                return $this->trelloServices->saveUserTrello($data, $telegram_id);
            } else {
                return "Server error";
            }
        } catch (\Exception $e) {
            return "User \"$username\" from this name is not in Trello";
        }
    }

    public function card($json): string
    {
        $data = json_decode($json, true);

        if(is_array($data) && isset($data['action']['display']['translationKey'])) {
            switch ($data['action']['display']['translationKey']) {
                case 'action_create_card':
                    $this->text = $this->cardCreateText($data);
                    break;
                case 'action_move_card_from_list_to_list':
                    $this->text = $this->cardMoveText($data);
                    break;
                case 'action_member_joined_card':
                    $this->text = $this->trelloServices->setUserToCard($data);
                    break;
                case 'action_member_left_card':
                    $this->text = $this->trelloServices->deleteUserFromCard($data);
                    break;
                default:
                    //
            }
        }
        return $this->text;
    }

    protected function cardCreateText(array $data)
    {
        $name_card = $data['action']['data']['card']['name'];

        return "Card " . $name_card . " was created.";
    }

    protected function cardMoveText(array $data)
    {
        $name_card = $data['action']['data']['card']['name'];
        $list_before = $data['action']['data']['listBefore']['name'];
        $list_after = $data['action']['data']['listAfter']['name'];

        return "The card " . $name_card . " has been moved from " . $list_before . " To " . $list_after;
    }
}
