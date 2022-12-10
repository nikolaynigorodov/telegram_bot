<?php

namespace App\Http\Controllers;

use App\Api\TelegramApi;
use App\Api\TrelloApi;
use Illuminate\Http\Request;

class TrelloController extends Controller
{
    private TrelloApi $trelloApi;
    private TelegramApi $telegramApi;

    public function __construct(TrelloApi $trelloApi, TelegramApi $telegramApi)
    {
        $this->trelloApi = $trelloApi;
        $this->telegramApi = $telegramApi;
    }

    public function __invoke(Request $request)
    {
        $text = $this->trelloApi->card($request->getContent());

        if(!empty($text)) {
            $this->telegramApi->sendFromTrelloDesc($text);
        }

    }
}
