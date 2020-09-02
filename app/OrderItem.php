<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
    	'order_id',
			'pai_style',
			'pai_color',
			'pai_variation',
			'sku',
			'customer_color',
			'size',
			'quantity_ordered',
			'unit_price',
			'total_price',
    ];
}
