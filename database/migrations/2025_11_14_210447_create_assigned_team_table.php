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
    Schema::create('assigned_team', function (Blueprint $table) {
        $table->id('idAssigned_Team');
        $table->unsignedBigInteger('Equipment_id');
        $table->unsignedBigInteger('Assignment_id');
         $table->tinyInteger('Status')->default(1);
        $table->timestamps();

        $table->foreign('Equipment_id')->references('idEquipment')->on('equipment');
        $table->foreign('Assignment_id')->references('idAssignment')->on('assignments');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_team');
    }
};