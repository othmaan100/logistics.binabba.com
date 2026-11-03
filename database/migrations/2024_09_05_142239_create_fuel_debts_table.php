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
        Schema::create('fuel_debts', function (Blueprint $table) {
            $table->bigIncrements('fdid');
            $table->string('truck_id');
            $table->string('company');
            $table->string('diesel_cost');
            $table->string('liters');
            $table->string('debt_date');
            $table->string('payment_date');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_debts');
    }
};
