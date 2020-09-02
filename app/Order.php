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
		'status'
    ];
}
