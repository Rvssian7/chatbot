<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class ReservaConversation extends Conversation
{

	public function run()
	{

		$question = Question::create('Que tipo de reserva quieres realizar ? ')
			->addButtons([
				Button::create('Reservar Habitación')->value('habitacion'),
				Button::create('Reservar jacuzzi')->value('jacuzzi'),
				Button::create('Reseervar GYM')->value('gym'),
				Button::create('Reservar Sendero')->value('sendero')
			]);

		$this->ask($question, function ($answer) {
			if ($answer->getValue() === 'habitacion') {
				$this->habitacion();
			}
		});
	}


	public function habitacion()
	{
		$data = [];

		$this->ask('Cual es tu nombre ?', function ($answer) use (&$data) {
			$data['nombre'] = $answer->getValue();
			$this->ask('Numero de Identificación', function ($answer) use (&$data) {
				$data['identificacion'] = $answer->getValue();
				$this->ask('Fecha de nacimiento (YYYY-MM-DD)', function ($answer) use (&$data) {
					$data['fecha_nacimiento'] = $answer->getValue();
					$this->ask('Correo', function ($answer) use (&$data) {
						$data['correo'] =  $answer->getValue();
						$this->ask('Direccion', function ($answer) use (&$data) {
							$data['direccion'] =  $answer->getValue();
							$this->ask('Telefono', function ($answer) use (&$data) {
								$data['telefono'] =  $answer->getValue();
								$this->ask('Cuantas Noches', function ($answer) use (&$data) {
									$data['cuantas_noches'] =  $answer->getValue();
									$this->ask('Cuantas Personas', function ($answer) use (&$data) {
									    $data['cuantas_personas'] =  $answer->getValue();
									    $this->reservarHabitacion($data);				
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


	public function reservarHabitacion($data){}
}
