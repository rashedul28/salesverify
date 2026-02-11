<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['offer_source_id', 'offer_id', 'source_id', 'offer_source_name', 'offer_name', 'user_id'];
}