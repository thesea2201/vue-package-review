<?php 

namespace TS2201\VuePageReview\Models;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'page_id', 
        'username', 
        'comment'
    ];
}

?>