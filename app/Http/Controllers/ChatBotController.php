<?php

namespace App\Http\Controllers;

use App\Conversations\Menu;
use App\Http\Conversations\HabitacionConversation;
use App\Http\Conversations\HousekeepingConversation;
use App\Http\Conversations\TransporteConversation;
use BotMan\BotMan\BotMan;
use App\Http\Conversations\ReservaConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class ChatBotController extends Controller
{
    public function handle() {

        $botman = app('botman');
        $botman->hears('reserva', function (BotMan $bot) {
            $bot->startConversation(new ReservaConversation());
        });

        $botman->hears('habitacion', function (BotMan $bot) {
            $bot->startConversation(new HabitacionConversation());
        });

        $botman->hears('transporte', function (BotMan $bot) {
            $bot->startConversation(new TransporteConversation());
        });

        $botman->hears('house', function (BotMan $bot) {
            $bot->startConversation(new HousekeepingConversation());
        });

        $botman->listen();

    }
}
