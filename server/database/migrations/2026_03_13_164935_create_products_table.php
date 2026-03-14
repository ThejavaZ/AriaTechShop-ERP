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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150); // Más espacio para nombres largos de hardware
            $table->string('slug')->unique(); // Útil para URLs amigables en Next.js
            $table->text('description')->nullable(); // Para el detalle del producto

            // Relación con categorías (ya preparada para la futura tabla)
            // constrained() fallará si la tabla categories no existe aún.
            // Si no la has creado, usa: $table->unsignedBigInteger('category_id');
            $table->integer('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->integer('stock')->default(0); // Cambié 'quantity' por 'stock', más estándar en ERPs
            $table->integer('min_stock')->default(5); // Útil para alertas de inventario

            $table->decimal('price', 12, 2); // 12 dígitos para que aguante precios de servidores caros
            $table->decimal('cost', 12, 2)->default(0); // Importante para calcular utilidades en el ERP

            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);

            // Auditoría (Relacionados con la tabla users)
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
