<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesFileMatch extends Model
{
    protected $fillable = ['source_id', 'offer_source_name', 'offer_name', 'sale_date', 'sales_count'];
}
