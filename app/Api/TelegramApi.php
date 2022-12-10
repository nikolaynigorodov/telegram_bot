<?php


namespace App\Api;


use App\Services\TelegramService;
use Telegram\Bot\BotsManager;

class TelegramApi
{
    const TEXT_MESSAGE = 'Hello';

    private BotsManager $botsManager;
    private TelegramService $service;
    private TrelloApi $trelloApi;

    public function __construct(BotsManager $botsManager, TelegramService $service, TrelloApi $trelloApi)
    {
        $this->botsManager = $botsManager;
        $this->service = $service;
        $this->trelloApi = $trelloApi;
    }

    public function sendFromTrelloDesc(string $text)
    {
        if($text) {
            $bot = $this->botsManager->bot();
            $bot->sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text
            ]);
        }
    }

    public function init()
    {
        $webhook = $this->botsManager->bot()->commandsHandler(true);

        $data = $webhook->getMessage();

        $command = explode("@", $data->text);

        if($command[0] == '/start') {
            $bot = $this->botsManager->bot();
            $bot->sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => self::TEXT_MESSAGE . ", " .$this->service->saveAndReturnName($data)
            ]);
        } elseif (isset($command[0]) && isset($command[1]) && $command[0] == '/trello') {
            $bot = $this->botsManager->bot();
            $text = $this->trelloApi->getUserTrello($command[1], $data->from->id);
            $bot->sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text
            ]);
        } elseif ($data->text == "Report") {
            $bot = $this->botsManager->bot();
            $text = $this->service->getAllInformation();
            $bot->sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text
            ]);
        }

    }
}
