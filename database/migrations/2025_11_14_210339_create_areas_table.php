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
    Schema::create('areas', function (Blueprint $table) {
        $table->id('idArea');
        $table->string('Name', 70);
        $table->tinyInteger('Status')->default(1);
        $table->unsignedBigInteger('Headquarters_id');
        $table->timestamps();

        $table->foreign('Headquarters_id')->references('idHeadquarters')->on('headquarters');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};