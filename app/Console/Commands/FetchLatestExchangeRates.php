<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExchangeRate;
use Carbon\Carbon;

class FetchLatestExchangeRates extends Command
{
    // This is the set of currencies which exchange rate we want
    private $currencies = ['USD','ARS','MXN', 'EUR'];
    private $baseCurrency = 'USD';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // We prepare our command to receive 'from' and 'to' (currency) values
    // When these values are set, the command won't perform a fetch but 
    // retrieve the last version of the given combination
    protected $signature = 'rates:update {from?} {to?} {amount?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the exchange rate table using the latest Fixer information at the time it is run';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // When these values are set, the command won't perform a fetch but 
        // retrieve the last version of the given combination
        if ($this->argument('from') && $this->argument('to')) {
            $from = $this->argument('from');
            $to = $this->argument('to');

            $rate = new ExchangeRate([], $from, $to);

            // Retrieve the current fetched record for the given combination
            $this->info('The last exchange rate record from ' . $from . ' to ' . $to . 
                            ' is: ' . $rate->lastExchange());

            // Perfom an actual convertion if a value is given
            if($this->argument('amount')){
                $this->info('The last exchange rate convertion for value '. 
                    $this->argument('amount') . ' from ' . $from . ' to ' . $to . 
                    ' is: ' . $rate->convert($this->argument('amount')));
            }   

            // Retrieve the yesterday's latest fetched record for the given combination
            $this->info('The last exchange rate record from ' . $from . ' to ' . $to . 
                        ' is: ' . $rate->lastExchange(Carbon::now()->subDay()));

            // Perfom an actual convertion if a value is given
            if($this->argument('amount')){
                $this->info('The last exchange rate convertion for value '. 
                    $this->argument('amount') . ' from ' . $from . ' to ' . $to . 
                    ' is: ' . $rate->convert($this->argument('amount'), Carbon::now()->subDay()));
            }
        } else {
            $this->info('Fetching data from Fixer.io');

            // We are going to use cURL to call the Fixer API and fetch the data
            $cURLConnection = curl_init();

            // Preparing the API call
            curl_setopt($cURLConnection, CURLOPT_URL, 'http://data.fixer.io/api/latest?access_key=' . 
            '0SbTnYZ7gCnBUIlRa1uIi0UuGqs9i8nZ'. '&symbols=' . implode(',', $this->currencies));
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            
            $fixerInfo = curl_exec($cURLConnection);

            curl_close($cURLConnection);

            $response = json_decode($fixerInfo, true);

            // If we get a valid response
            if ( $response !== null && $response['success'] === true) {
                $rates = $response['rates'];

                foreach($this->currencies as $currency){

                    // We try to find an older version of the new combination of base currency
                    // and destionation currency using USD as our base currency
                    $previous = ExchangeRate::where('from_currency', $this->baseCurrency)
                                ->where('to_currency', $currency)
                                ->whereNull('until')->get()->first();

                    // If a previous version exists, we set its due date
                    if(!is_null($previous)){
                        $previous->until = Carbon::now();
                        $previous->updated_at = Carbon::now();
                        $previous->save();
                    }

                    // We prepare the new record using USD as our base currency
                    $new['from_currency'] = $this->baseCurrency;
                    $new['to_currency'] = $currency;
                    $new['rate'] = $rates[$currency] / $rates[$this->baseCurrency];
                    $new['since'] = Carbon::now();
                    $new['created_at'] = Carbon::now();
                    $new['updated_at'] = Carbon::now();

                    $newRate = ExchangeRate::create($new);

                    $this->info(Carbon::now() . 
                        ' The new convertion rate from ' . $newRate->from_currency . 
                        ' to ' . $newRate->to_currency . 
                        ' is ' . $newRate->rate . 
                        ' available at ' .  $newRate->since);
                }       
            }
        }
    }
}