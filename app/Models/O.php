<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class O extends Model
{
    use HasFactory;


    protected $table = 'oauth_access_tokens';
    protected $fillable =
     [
    'id'
    ,'user_id'
    ,'client_id'
    ,'name'
    ,'scopes'
    ,'revoked'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
