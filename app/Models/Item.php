<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use  HasFactory;
 
    protected $table = 'items';
    protected $fillable =
     [
    'categorie_id'
    ,'title'
    ,'user_id'
    ,'contact_information'
    ,'expiration_date'
    ,'quantity'
    ,'price'
    ,'img'  
    ,'likes'
    ,'views'
    ,'new_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 /*___________________________________________________________________________________________________________________________________*/

    public function categories() {
        return $this->belongsTo(Category::class );
    }
 /*___________________________________________________________________________________________________________________________________*/
    public function offer()
    {
        return $this->hasone(Offer::class );
    }
 /*___________________________________________________________________________________________________________________________________*/

    public function comment()
    {
        return $this->hasmany(Comment::class );
    }

    // scope

    //get all element that have more $num element ID
    public function scopeId_More_Than_5($query)
    {
        return $query->where('id', '>',5);
    }
    
 
    //get all element that have more $num element quantity
    public function scopeQuantity_more($query,$num)
    {
        $query->where('quantity','>', $num);
    }

}