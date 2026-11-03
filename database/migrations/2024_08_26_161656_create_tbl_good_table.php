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
        Schema::create('tbl_good', function (Blueprint $table) {
            $table->increments('good_id');
            $table->string('good_id_no')->unique();
            $table->string('truck_id');
            $table->string('driver_id');
            $table->string('good_type');
            $table->string('good_weight');
            $table->string('good_cost');
            $table->string('diesel_cost');
            $table->string('liters');
            $table->string('commission');
            $table->string('road_expenses');
            $table->string('client_id');
            $table->string('good_date_of_pickup');
            $table->string('good_date_of_delivery');
            $table->string('good_pickup_point');
            $table->string('good_delivery_point');
            $table->string('payment_status')->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_good');
    }
};
