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
    Schema::create('bosses', function (Blueprint $table) {
        $table->id('idBoss');
        $table->string('Document', 8);
        $table->string('Name', 70);
        $table->string('Cargo', 70);
        $table->unsignedBigInteger('Area_id');
        $table->string('Phone', 20)->nullable();
         $table->tinyInteger('Status')->default(1);
        $table->timestamps();

        $table->foreign('Area_id')->references('idArea')->on('areas');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bosses');
    }
};