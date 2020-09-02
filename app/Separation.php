<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Separation extends Model
{
    protected $fillable = [
    	'employee_id',
			'employee_name',
			'supervisor_id',
			'supervisor_name',
			'last_day_worked',
			'department',
			'separation_date',
			'quit_terminated',
			'type_of_notice',
			'termination_type',
			'disciplinary_action',
			'level_of_severity',
			'reason',
			'notes',
    ];
}
