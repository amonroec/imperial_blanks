<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'po_number',
		'email',
		'ship_to',
		'address',
		'city',
		'state',
		'zip_code',
		'token',
		'user_name',
		'user_email',
		'user_id',
		'customer_number',
		'status',
		'sold_to',
		'payment_type',
		'stripe_id'
    ];
    protected $casts = ['sold_to' => 'object', 'ship_to' => 'object'];
}
