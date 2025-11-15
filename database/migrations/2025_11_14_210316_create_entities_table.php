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
    Schema::create('entities', function (Blueprint $table) {
        $table->id('idEntity');
        $table->string('Razon', 50);
        $table->string('Ruc', 11);
        $table->string('Representative', 70);
        $table->string('Address', 70);
        $table->string('Phone', 20)->nullable();
        $table->string('Correo', 50);
        $table->string('Image', 200)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};