<?php


namespace App\TelegramCommands;


use Telegram\Bot\Commands\Command;

class TrelloCommand extends Command
{
    protected $name = 'trello';

    protected $description = 'User integration with Trello /trello@USERNAME';

    public function handle()
    {
        /*$this->replyWithMessage([
            'text' => "test"
        ]);*/
    }
}
