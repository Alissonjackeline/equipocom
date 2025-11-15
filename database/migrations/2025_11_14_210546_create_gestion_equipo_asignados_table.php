<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('gestion_equipo_asignados', function (Blueprint $table) {
        $table->id('id');
        $table->unsignedBigInteger('Assignment_id');
        $table->unsignedBigInteger('Equipment_id');
        $table->unsignedBigInteger('User_id');
        $table->dateTime('Date');
        $table->boolean('Devolucion');
        $table->string('Document', 200)->nullable();
        $table->string('Image', 200)->nullable();
        $table->string('Comment', 150)->nullable();
        $table->tinyInteger('Status')->default(1);
        $table->timestamps();

        $table->foreign('Assignment_id')->references('idAssignment')->on('assignments');
        $table->foreign('Equipment_id')->references('idEquipment')->on('equipment');
        $table->foreign('User_id')->references('idUser')->on('users');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_equipo_asignados');
    }
};