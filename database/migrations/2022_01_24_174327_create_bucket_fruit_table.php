<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucketFruitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket_fruit', function (Blueprint $table) {
            $table->unsignedBigInteger('bucket_id');
            $table->unsignedBigInteger('fruit_id');

            $table->foreign('bucket_id')->references('id')->on('buckets');
            $table->foreign('fruit_id')->references('id')->on('fruits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bucket_fruit');
    }
}
