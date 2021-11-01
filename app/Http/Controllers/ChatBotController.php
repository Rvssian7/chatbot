<?php

namespace App\Http\Controllers;

use App\Http\Conversations\HabitacionConversation;
use App\Http\Conversations\TransporteConversation;
use BotMan\BotMan\BotMan;
use App\Http\Conversations\ReservaConversation;

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

        $botman->listen();
    }
}
