<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete amgad';

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
     * @return int
     */
    public function handle()
    {
      $a= User::where('first_name','amgad')->first();
      $a->delete();


    }
}
