<?php

namespace App\Http\Conversations;

use App\Http\Controllers\ConversationController;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class HousekeepingConversation extends Conversation
{

    private $values = [
        0 => 'Toallas',
        1 => 'Almohadas',
        2 => 'Planchas',
        3 => 'Cobijas',
        4 => 'Solicitud de mantenimiento',
        5 => 'Mesas y sillas',
        6 => 'Amenities',
    ];

    public function run() {
        $question = Question::create('')
            ->addButtons([
                Button::create('1) Toalla')->value($this->values[0]),
                Button::create('2) Almohadas')->value($this->values[1]),
                Button::create('3) Planchas')->value($this->values[2]),
                Button::create('4) Cobijas')->value($this->values[3]),
                Button::create('5) Solicitud de mantenimiento')->value($this->values[4]),
                Button::create('6) Mesas y sillas')->value($this->values[5]),
                Button::create('7) Amenities')->value($this->values[6]),
            ]);

        $this->ask($question, function ($answer) {
            $this->send($answer->getValue());
        });

    }

    public function amenities(&$data,$type) {
        $question = Question::create('Tipo de Kit')
            ->addButtons([
                Button::create('1- Kit Dental')->value('Kit Dental'),
                Button::create('2- Kit Afeitar')->value('Kit Afeitar'),
            ]);

        $this->ask($question, function ($answer) use (&$data, $type) {
            $data['Kit'] = $answer->getValue();
            $this->saveService($data, 'HOUSEKEEPING', $type);
            $this->say('Servicio en camino');
        });
    }

    public function send($type) {
        $data = [];
        $this->ask('Numero de habitación', function ($answer) use (&$data, $type) {
            $data['habitacion'] = $answer->getValue();
            $this->ask('Cual es tu nombre ?', function ($answer) use (&$data, $type) {
                $data['nombre'] = $answer->getValue();
                if ($type === $this->values[6]) {
                    $this->amenities($data,$answer->getValue());
                } else {
                    $this->saveService($data, 'HOUSEKEEPING', $type);
                    $this->say('Servicio en camino');
                }
            });
        });
    }

    public function saveService($data, $type, $subtype) {
        ConversationController::save($data, $type, $subtype);
    }
}
