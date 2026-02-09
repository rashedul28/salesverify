<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    protected $fillable = ['offer_source_id', 'name'];

    public function source(): BelongsTo
    {
        return $this->belongsTo(OfferSource::class, 'offer_source_id');
    }
}