<?php


namespace App\TelegramCommands;


use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TrelloReportCommand extends Command
{
    protected $name = 'trelloReport';

    protected $description = 'Get all user information for trello tasks';

    public function handle()
    {
        $keyboard = new Keyboard();

        $button = $keyboard::button([
            'text' => "Report",
        ]);

        $keyboard->setResizeKeyboard(true);
        $keyboard->setOneTimeKeyboard(true);
        $keyboard->row($button);

        $this->replyWithMessage([
            'text' => "Get all user information",
            'reply_markup' => $keyboard
        ]);
    }
}
