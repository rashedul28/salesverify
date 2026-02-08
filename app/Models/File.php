<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['date_time', 'offer_source', 'offer_name', 'country', 'source_id', 'referrer'];
}