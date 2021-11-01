<?php

namespace App\Http\Conversations;

use App\Http\Controllers\ConversationController;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class HabitacionConversation extends Conversation
{

    private $values = [
        1 => 'Salmon a la brasa',
        2 => 'Baby Beef',
        3 => 'Pollo al estilo Waya',
        4 => 'Hamburguesa Tradicional',
        5 => 'Sándwich de Carne',
        6 => 'Wrap de Pollo',
        7 => 'Dulces Tipicos',
        8 => 'Cheesecake con salsa de agras',
        9 => 'Cerveza importada',
        10 => 'Cerveza nacional',
        11 => 'Gaseosa 400 ml',
        12 => 'Gaseosa 600 ml - $9.000',
        13 => 'Gaseosa 600 ml - $7.000',
        14 => 'Hablar con un asesor',
    ];

    public function run() {
        $question = Question::create('Lista de comidas y bebidas disponibles.')
            ->addButtons([
                Button::create('1) Salmon a la brasa - $44.000')->value($this->values[1]),
                Button::create('2) Baby Beef - $42.000')->value($this->values[2]),
                Button::create('3) Pollo al estilo Waya - $34.000')->value($this->values[3]),
                Button::create('4) Hamburguesa Tradicional - $27.000')->value($this->values[4]),
                Button::create('5) Sándwich de Carne - $21.000')->value($this->values[5]),
                Button::create('6) Wrap de Pollo - $25.000')->value($this->values[6]),
                Button::create('7) Dulces Tipicos - $10.000')->value($this->values[7]),
                Button::create('8) Cheesecake con salsa de agras - $10.000 ')->value($this->values[8]),
                Button::create('9) Cerveza importada - $9.000')->value($this->values[9]),
                Button::create('10) Cerveza nacional - $16.000')->value($this->values[10]),
                Button::create('11) Gaseosa 400 ml - $8.000')->value($this->values[11]),
                Button::create('12) Gaseosa 600 ml - $9.000')->value($this->values[12]),
                Button::create('13) Gaseosa 600 ml - $7.000')->value($this->values[13]),
                Button::create('14) Hablar con un asesor')->value($this->values[14]),
            ]);

        $this->ask($question, function ($answer) {
            if ($answer->getValue() !== $this->values[14])
                $this->generica($answer->getValue());
        });
    }

    public function generica($type) {
        $data = [];
        $this->ask('Numero de habitación', function ($answer) use (&$data, $type) {
            $data['habitacion'] = $answer->getValue();
            $this->ask('Cual es tu nombre ?', function ($answer) use (&$data, $type) {
                $data['nombre'] = $answer->getValue();
                $this->formaPago($data, $type);
            });
        });
    }

    public function formaPago(&$data, $type) {
        $question = Question::create('Forma de pago')
            ->addButtons([
                Button::create('1- Pago en efectivo')->value('Efectivo'),
                Button::create('2- Pago con tarjeta')->value('Tarjeta'),
                Button::create('3- Cargo a la habitación')->value('Cargo a la Habitación'),
            ]);

        $this->ask($question, function ($answer) use (&$data, $type) {
            $data['forma de pago'] = $answer->getValue();
            $this->saveService($data, 'SERVICIO A LA HABITACIÓN', $type);
            $this->say('Su servicio está en proceso, feliz día.');
        });
    }

    public function saveService($data, $type, $subtype) {
        ConversationController::save($data, $type, $subtype);
    }
}
