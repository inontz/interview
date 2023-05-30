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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained();
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country');
            $table->string('tel_phone');
            $table->boolean('tax_request')->default(false);
            $table->string('tax_identification')->nullable();
            $table->string('tax_address_line_1')->nullable();
            $table->string('tax_address_line_2')->nullable();
            $table->string('tax_city')->nullable();
            $table->string('tax_postal_code')->nullable();
            $table->string('tax_country')->nullable();
            $table->string('tax_tel_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
