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
    Schema::create('assignments', function (Blueprint $table) {
        $table->id('idAssignment');
        $table->unsignedBigInteger('User_id');
        $table->unsignedBigInteger('Boss_id');
        $table->dateTime('Date');
        $table->string('Document', 200)->nullable();
        $table->string('Image', 200)->nullable();
        $table->string('Comment', 150)->nullable();
        $table->tinyInteger('Status')->default(1);
        $table->timestamps();

        $table->foreign('User_id')->references('idUser')->on('users');
        $table->foreign('Boss_id')->references('idBoss')->on('bosses');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};