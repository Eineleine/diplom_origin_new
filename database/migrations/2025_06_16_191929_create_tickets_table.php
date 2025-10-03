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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('seance_id');
            $table->unsignedInteger('seat_id');
            $table->date('seance_date'); 
            $table->unsignedInteger('code')->unique();
            $table->timestamps();
            $table->unique(['seance_id', 'seat_id', 'seance_date']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        

        Schema::dropIfExists('tickets');
    }
};

