<?php

namespace App\Http\Conversations;

use App\Http\Controllers\ConversationController;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class TransporteConversation extends Conversation
{
    private $values = [
        0 => [
            'type' => 'Pasadía cabo de la vela',
            'description' => 'Descripcion: Salida 06:30 Am despues de tomar el desayuno del hotel
                Transporte en 4x4 full aire, visita a uribia, capital indigena y manaure, visita a las salinas.
                incluye almuerzo (No a la carta)'
        ],
        1 => [
            'type' => 'Pasadía playa Mayapo',
            'description' => 'Descripción: Salida 08:30 Am después de tomar el desayuno del hotel
                Transporte en vehículo automóvil,incluye almuerzo'
        ],
        2 => [
            'type' => 'Pasadía Camarones',
            'description' => 'Descripción: Salida 08:30 Am después de tomar el desayuno del hotel
                Transporte en vehículo automóvil, incluye almuerzo'
        ],
        3 => [
            'type' => 'Pasadía Palomino',
            'description' => 'Descripción: Salida 08:30 Am después de tomar el desayuno del hotel
                Transporte en vehículo automóvil, incluye almuerzo'
        ],
        4 => [
            'type' => 'Ruta Vallenata',
            'description' => 'Descripción: Salida 07:00 Am después de tomar el desayuno del hotel
                Transporte en vehículo automóvil, recorrido por los municipios de la provincia de padilla
                (Hatonuevo,Barrancas, Distraccion, -fonseca) Visita a la ventana marroncita, entrada y salida al museo
                del cacique de la junta Diomedes Diaz incluye almuerzo'
        ],
        5 => [
            'type' => 'Tour cabo de la vela, noche de alojamiento',
            'description' => 'Descripcion: Salida 08:30 Am despues de tomar el desayuno del hotel
                Transporte en 4x4 full aire, visita a uribia, capital indigena y manaure, visita a las salinas.
                visita al cabo de la vela del pilon de azucar, el faro, ojo del agua incluye 2 almuerzo - 1 Cena -1 desayuno'
        ],
        6 => [
            'type' => 'Tour Punta Gallina, noche de alojamiento',
            'description' => 'Descripcion: Salida 08:30 Am despues de tomar el desayuno del hotel
                Transporte en 4x4 full aire, visita a uribia, capital indigena y manaure, visita a las salinas.
                visita al cabo de la vela del pilon de azucar, el faro, ojo del agua, recorrido en lancha a
                puerto bolivar - bahia hondita - punta soldado - punta aguja - visita a las dunas de taroa - faro de punta gallinas
                incluye 3 almuerzo - 2 Cena -2 desayuno'
        ],
        7 => ['type' => 'Hablar con un asesor', 'description' => '']
    ];

    public function run() {
        $question = Question::create('Lista de comidas y bebidas disponibles.')
            ->addButtons([
                Button::create('1) Tour pasadía cabo de la vela')->value($this->values[0]['type']),
                Button::create('2) Tour pasadía playa mayapo')->value($this->values[1]['type']),
                Button::create('3) Tour pasadía camarones')->value($this->values[2]['type']),
                Button::create('4) Tour pasadía palomino')->value($this->values[3]['type']),
                Button::create('5) Tour ruta vallenata')->value($this->values[4]['type']),
                Button::create('6) Tour cabo de la vela, noche de alojamiento')->value($this->values[5]['type']),
                Button::create('7) Tour Punta Gallina, noche de alojamiento')->value($this->values[6]['type']),
                Button::create('8) Hablar con un asesor')->value($this->values[7]['type']),
            ]);

        $this->ask($question, function ($answer) {
            if ($answer->getValue() !== $this->values[7]['type']) {
                $key = array_search($answer->getValue(), array_column($this->values, 'type'), false);
                $this->descripcion($this->values[$key]['description'], $answer->getValue());
            }
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
                $this->send($type);
            } else {
                $this->run();
            }
        });
    }

    public function send($type) {
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
            $this->saveService($data, 'TRANSPORTE', $type);
            $this->say('Su reserva esta confirmada, feliz día.');
        });
    }

    public function saveService($data, $type, $subtype) {
        ConversationController::save($data, $type, $subtype);
    }
}
