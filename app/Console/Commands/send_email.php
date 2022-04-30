<?php

namespace App\Console\Commands;

use App\Mail\verifay_email_warning;
use App\Mail\verifyEmail;
use App\Mail\WarningVerifyEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class send_email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a warning email to a user hasnt verifay his email ';

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
        // echo "test";
           $Users= User::all()->where('email_verified',0);
        


        //  Mail::to("amgad@gmail.com")->send(new WarningVerifyEmail ());


//    $Users->password = 'amgad12311';
//    $Users->save();
// Mail::to('amgad@gmail.com')->send(new verifay_email_warning ());

   foreach ($Users as $user)
   {
    Mail::to($user->email)->send(new WarningVerifyEmail ($user->first_name));
   }

    }
}
