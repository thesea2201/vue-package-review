<?php
namespace TS2201\PageReview\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['path'];


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}


?>