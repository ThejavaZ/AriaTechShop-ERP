<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
        $table->id(); // El ID que ves: 1023, 1024...

        // Relación con el cliente (asumiendo que usas tu tabla users)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('equipment'); // Ejemplo: Laptop HP
        $table->string('model')->nullable(); // Opcional: iPhone 13

        // Para el "Estado" (Listo, En reparación)
        // Usamos string o tinyInteger según prefieras para tu lógica de colores
        $table->string('status')->default('pending'); 

        $table->text('fault_description')->nullable(); // Qué le falla
        $table->decimal('total_cost', 10, 2)->default(0);

        $table->timestamps(); // Esto genera 'created_at' que será tu columna 'Fecha'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
