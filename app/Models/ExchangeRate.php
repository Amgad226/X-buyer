<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRate extends Model
{
    // We override the constructor to set if given the default 'from' 
    // and 'to' currencies values
    public function __construct(array $attributes = array(), 
                                    $from = null, $to = null)
    {
        parent::__construct($attributes);

        if($from && $to)
        {
            $this->from_currency = $from;
            $this->to_currency = $to;
        }
    }

    protected $table = 'public.exchange_rates';

    protected $fillable = ['from_currency', 'to_currency', 'rate', 'since', 
                            'until', 'created_at', 'updated_at', 'deleted_at'];

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function lastExchange($by = null){
        // Retrieving the last record for the given from and to values set when 
        // the model was instantiated

        // If a top date is set, we retrieve the most recent value by the given date
        if($by){
            return self::where('from_currency', $this->from_currency)
                ->where('to_currency', $this->to_currency)
                ->where('until', '<=', $by)
                ->orderBy('until', 'DESC')
                ->get()->first();
        } else {
        // Else, we retrive the current stored value
            return self::where('from_currency', $this->from_currency)
                ->where('to_currency', $this->to_currency)
                ->whereNull('until')
                ->get()->first();
        }
    }

    // A method for direct exchange rate calculation
    public function convert($value, $by = null){
        return $this->lastExchange($by)->rate * $value;
    }
}