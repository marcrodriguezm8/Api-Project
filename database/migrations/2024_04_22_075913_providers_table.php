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
        //
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('provider_phone')->nullable();
            $table->string('provider_email')->unique();
            $table->string('provider_location');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
