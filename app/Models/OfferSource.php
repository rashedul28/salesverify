<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferSource extends Model
{
    protected $fillable = ['name'];

    public function offers()
    {
        return $this->hasMany(Offer::class, 'offer_source_id');
    }
}