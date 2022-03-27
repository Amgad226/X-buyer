<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('img')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('email_verified')->default(false);
            $table->string('provider_id')->nullable();
            $table->date('email_verified_at')->nullable();
            
        }); 
        
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}