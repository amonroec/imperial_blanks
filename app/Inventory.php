<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
    	'customer_number',
    	'customer_name',
    	'customer_style',
    	'customer_color',
    	'description',
    	'booking_style',
    	'booking_color',
    	'pai_color',
    	'sbdim',
    	'size',
    	'seq',
    	'fg_units',
    	'orders',
    	'available_units',
    	'oo_units',
    	'total_available',
    	'our_price',
    	'retail_price'
    ];
}
