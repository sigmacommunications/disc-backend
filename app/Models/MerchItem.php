<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchItem extends Model
{
    protected $guarded = [];
    public function images()
    {
        return $this->hasMany(MerchItemImage::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
