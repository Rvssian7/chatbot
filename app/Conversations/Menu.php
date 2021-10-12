<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class Menu extends Conversation
{

    public function run()
    {

        $question = Question::create('Hola soy tu asistente virtual, En que te puedo ayudar ? ')
            ->addButtons([
                Button::create('Reserva')->value('reserva'),
                Button::create('Servicio a la habitacion')->value('servicio a la habitación'),
                Button::create('Transporte')->value('transporte'),
                Button::create('Housekeeping')->value('housekeeping')
            ]);

        $this->ask($question, function (Answer $answer) use ($question) {
            if ($answer->getValue() === 'reserva') {
                
            }
        });
    }
}

