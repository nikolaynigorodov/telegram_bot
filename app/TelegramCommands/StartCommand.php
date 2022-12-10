<?php


namespace App\TelegramCommands;


use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected $name = 'start';

    protected $description = 'Start Command';

    public function handle()
    {
        /*$this->replyWithMessage([
            'text' => "test"
        ]);*/
    }
}
