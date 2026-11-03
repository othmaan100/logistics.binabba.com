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
        Schema::create('tbl_drivers', function (Blueprint $table) {
            $table->bigIncrements('driver_id');
            $table->string('driver_id_no',10)->unique();
            $table->string('driver_name');
            $table->string('driver_phone',11);
            $table->text('driver_address')->nullable();
            $table->string('driver_image');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_drivers');
    }
};
