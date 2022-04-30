<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->bigIncrements('id');

            // This is going to be our base currency
            $table->string('from_currency');

            // And this is the destination currency
            $table->string('to_currency');

            // Rate is our exchange value. For example, it will be 0.83  USD to EUR on Feb 3rd, 2021 1:00 AM UTC
            $table->decimal('rate');

            // The timestamp when the exchange rate is fetched from the Fixer API
            $table->timestamp('since');

            // The timestamp when a new version of the exchange rate is fetched.
            // The current exchange version will be null as there is not a new ending timestamp.
            $table->timestamp('until')->nullable();

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
        Schema::dropIfExists('exchange_rates');
    }
}