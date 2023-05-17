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
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('price')->nullable();
            $table->string('url')->nullable();
            $table->string('pic_url')->nullable();
            $table->integer('instock')->defaultValue('0');
            $table->timestamps();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
