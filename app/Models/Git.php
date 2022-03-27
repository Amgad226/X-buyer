<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Git extends Model
{
    use  HasFactory;
 
        protected $table = 'oauth_access_tokens';
        protected $fillable =
        [
        'id'
        ,'user_id'
        ,'client_id'
        ,'name'
        ,'scope'
        ,'revoked'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }