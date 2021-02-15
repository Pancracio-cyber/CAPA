<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *  
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('llave')->nullable();
            $table->string('id_tramite')->nullable();
            $table->string('no_solicitud')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->time('hora_solicitud')->nullable();
            $table->decimal('no_solicitud_api');
            $table->time('hora_solicitud_api')->nullable();
            $table->date('fecha_solicitud_api')->nullable();
            $table->string('id_estado')->nullable();
            $table->string('id_electronico')->nullable();
            $table->string('referencia_pago')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->time('hora_pago')->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('direccion')->nullable();
            $table->string('colonia')->nullable();
            $table->string('importe')->nullable();
            $table->date('fechalimite')->nullable();
            $table->string('sector')->nullable();
            $table->string('manzana')->nullable();
            $table->string('lote')->nullable();
            $table->string('tarifa')->nullable();
            $table->string('tipo_servicio')->nullable();
            $table->string('no_medidor')->nullable();
            $table->string('diametroToma')->nullable();
            $table->string('stripe_orden_id')->nullable();
            $table->string('stripe_creado')->nullable();
            $table->string('stripe_mensaje')->nullable();
            $table->string('stripe_tipo')->nullable();
            $table->string('stripe_digitos')->nullable();
            $table->string('stripe_red')->nullable();
            $table->string('stripe_estado')->nullable();
            $table->string('xml_url')->nullable();
            $table->string('no_consulta')->nullable();
            $table->integer('no_contrato')->nullable();
            $table->integer('id_municipio')->nullable();
            $table->string('calle1')->nullable();
            $table->string('calle2')->nullable();
            $table->string('id_firmante')->nullable();
            $table->string('id_sello')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
