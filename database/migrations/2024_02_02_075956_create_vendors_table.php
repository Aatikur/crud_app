<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name')->nullable(false);
            $table->bigInteger('location_id')->unsigned()->index()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->longText('address')->nullable(false);
            $table->longText('gst_details')->nullable(false);
            $table->longText('bank_details')->nullable(false);
            $table->string('lane_name')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
