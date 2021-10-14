<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['RESERVA', 'SERVICIO A LA HABITACION', 'TRANSPORTE', 'HOUSEKEEPING']);
            $table->string('subtype');
            $table->enum('status', ['PENDIENTE', 'FINALIZDO', 'EN PROCESO'])->default('PENDIENTE');
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('conversations');
    }
}
