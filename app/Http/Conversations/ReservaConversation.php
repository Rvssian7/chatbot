<?php

namespace App\Http\Conversations;

use App\Http\Controllers\ConversationController;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class ReservaConversation extends Conversation
{

    public function run() {

        $question = Question::create('Que tipo de reserva quieres realizar ? ')
            ->addButtons([
                Button::create('Reservar Habitación')->value('habitacion'),
                Button::create('Reservar jacuzzi')->value('jacuzzi'),
                Button::create('Reseervar GYM')->value('gym'),
                Button::create('Reservar Sendero')->value('sendero')
            ]);

        $this->ask($question, function ($answer) {
            $option = $answer->getValue();
            switch ($option) {
                case 'habitacion':
                    $this->habitacion();
                    break;
                case 'jacuzzi':
                    $this->descripcion('Nota: El jacuzzi se encuentra disponible desde las 4 PM hasta las 10 PM.', 'JACUZZI');
                    break;
                case 'gym':
                    $this->descripcion('Nota: El Gym se encuentra disponible desde las 5 AM hasta las 10 PM.', 'GYM');
                    break;
                case 'sendero':
                    $this->descripcion('Nota: Primera salida: 9 AM \n Segunda salida: 3 PM', 'SENDERO');
                    break;
                default:
                    $this->run();
                    break;
            }
        });
    }

    public function habitacion() {
        $data = [];

        $this->ask('Cual es tu nombre ?', function ($answer) use (&$data) {
            $data['nombre'] = $answer->getValue();
            $this->ask('Numero de Identificación', function ($answer) use (&$data) {
                $data['identificacion'] = $answer->getValue();
                $this->ask('Fecha de nacimiento (YYYY-MM-DD)', function ($answer) use (&$data) {
                    $data['fecha_nacimiento'] = $answer->getValue();
                    $this->ask('Correo', function ($answer) use (&$data) {
                        $data['correo'] = $answer->getValue();
                        $this->ask('Direccion', function ($answer) use (&$data) {
                            $data['direccion'] = $answer->getValue();
                            $this->ask('Telefono', function ($answer) use (&$data) {
                                $data['telefono'] = $answer->getValue();
                                $this->ask('Cuantas Noches', function ($answer) use (&$data) {
                                    $data['cuantas_noches'] = $answer->getValue();
                                    $this->ask('Cuantas Personas', function ($answer) use (&$data) {
                                        $data['cuantas_personas'] = $answer->getValue();
                                        $this->saveReservation($data, 'RESERVA', 'HABITACIÓN');
                                        $this->say('En minutos recibira un correo con la confirmacion de su reserva, muchas gracias');
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    }

    public function descripcion($descripcion, $type) {
        $question = Question::create($descripcion)
            ->addButtons([
                Button::create('Reservar')->value('reservar'),
                Button::create('Volver')->value('volver'),
            ]);
        $this->ask($question, function ($answer) use ($type) {
            if ($answer->getValue() === 'reservar') {
                $this->generica($type);
            } else {
                $this->run();
            }
        });
    }

    public function generica($type) {
        $data = [];
        $this->ask('Numero de habitación', function ($answer) use (&$data, $type) {
            $data['habitacion'] = $answer->getValue();
            $this->ask('Cual es tu nombre ?', function ($answer) use (&$data, $type) {
                $data['nombre'] = $answer->getValue();
                $this->ask('Telefono', function ($answer) use (&$data, $type) {
                    $data['telefono'] = $answer->getValue();
                    $this->saveReservation($data, 'RESERVA', $type);
                    $this->say('En minutos recibira un correo con la confirmacion de su reserva, muchas gracias');
                });
            });
        });
    }

    public function saveReservation($data, $type, $subtype) {
        ConversationController::save($data, $type, $subtype);
    }

}
