<?php

namespace App\Http\Controllers;

use App\Api\TelegramApi;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TelegramWebHookController extends Controller
{
    private TelegramApi $telegramApi;

    public function __construct(TelegramApi $telegramApi)
    {
        $this->telegramApi = $telegramApi;
    }

    public function __invoke(Request $request)
    {
        $this->telegramApi->init();

        return response(null, Response::HTTP_OK);
    }
}
