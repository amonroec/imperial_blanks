<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
    	'department',
		'employee_id',
		'first_name',
		'last_name',
		'age',
		'gender',
		'manager',
		'date_hired',
		'date_terminated',
		'worked_here_before',
		'training',
    ];
}
