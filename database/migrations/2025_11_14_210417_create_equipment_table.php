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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('idEquipment');
            
            // Nueva clave foránea hacia equipment_types
            $table->unsignedBigInteger('EquipmentType_id');

            $table->string('CodigoPatri', 50);
            $table->string('Series', 50);
            $table->string('Model', 50);
            $table->string('Brand', 50);
            $table->string('Description', 150);
            $table->decimal('Price', 10, 2);
            $table->tinyInteger('status')->default(1);

            // Clave foránea hacia Supplier
            $table->unsignedBigInteger('Supplier_id');

            $table->string('Imagen', 200)->nullable();
            $table->timestamps();

            // Relación con suppliers
            $table->foreign('Supplier_id')
                ->references('idSupplier')
                ->on('suppliers');

            // Relación con equipment_types
            $table->foreign('EquipmentType_id')
                ->references('idEquipmentType')
                ->on('equipment_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};