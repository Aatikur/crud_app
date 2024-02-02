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
        Schema::create('agreement_details', function (Blueprint $table) {
            $table->id();
            $table->longText('file')->nullable(false);
            $table->bigInteger('vendor_id')->unsigned()->index()->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');;
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
        Schema::dropIfExists('agreement_details');
    }
};
