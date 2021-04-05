<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {  //id, coin, rate, datetime
            $table->uuid('id')->primary();
            $table->uuid('coin_id');
            $table->decimal('rate', 8, 4);
            $table->decimal('special_rate', 8, 4)->nullable();
            $table->string('source',191);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->index(['coin_id','source']);
            $table->foreign('coin_id')->references('id')->on('coin_metadata');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
