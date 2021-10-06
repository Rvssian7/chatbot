<?php

namespace App\Http\Controllers;

use App\Conversations\Menu;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

class ChatBotController extends Controller
{
    public function handle() {

        $botman = app('botman');
  
        $botman->hears('{message}', function(BotMan $botman,$message) {
            $botman->startConversation(new Menu); 
        });
  
        $botman->listen();
    }

}
