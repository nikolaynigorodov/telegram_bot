<?php


namespace App\TelegramCommands;


use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{
    protected $name = 'help';

    protected $description = 'Help Command';

    public function handle()
    {
        $this->replyWithChatAction([
            'action' => Actions::TYPING,
        ]);

        $response = '';
        $commands = $this->getTelegram()->getCommands();

        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command);
        }

        $this->replyWithMessage([
            'text' => $response
        ]);
    }
}
