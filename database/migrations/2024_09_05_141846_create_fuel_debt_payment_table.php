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
        Schema::create('fuel_debt_payment', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('payment_method');
            $table->string('payer');
            $table->string('amount_paid');
            $table->string('balance_before_payment');
            $table->string('balance_after_payment');
            $table->string('payment_date');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_debt_payment');
    }
};
