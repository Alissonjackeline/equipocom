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
    Schema::create('headquarters', function (Blueprint $table) {
        $table->id('idHeadquarters');
        $table->string('Name', 70);
        $table->string('Address', 70);
        $table->string('Phone', 20)->nullable();
         $table->tinyInteger('Status')->default(1);
        $table->unsignedBigInteger('Entity_id');
        $table->timestamps();

        $table->foreign('Entity_id')->references('idEntity')->on('entities');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headquarters');
    }
};