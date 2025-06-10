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
       Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
            
            // $table->integer('subtotal')->nullable(); // Bisa ditambahkan jika ingin menyimpan subtotal
            $table->timestamps();

            $table->unique(['order_id', 'menu_id']); // Optional, mencegah duplikasi menu dalam satu order
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
