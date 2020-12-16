<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmantesPdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmantes_pdf', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_firmante')->nullable();
            $table->string('primer_apellido_firmante')->nullable();
            $table->string('segundo_apellido_firmante')->nullable();
            $table->decimal('id_ municipio')->nullable();
            $table->string('cargo_firmante')->nullable();
            $table->date('fecha_vigencia_firmante')->nullable();
            $table->smallInteger('orden_firmas')->nullable();
            $table->string('estatus_firmante')->nullable();
            $table->string('url_img_firmante')->nullable();
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
        Schema::dropIfExists('firmantes_pdf');
    }
}
