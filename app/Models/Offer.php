<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['offer_source_id', 'name'];

    public function source()
    {
        return $this->belongsTo(OfferSource::class, 'offer_source_id');
    }
}