<?php 

namespace GAMAFin\Models;

use Illuminate\Database\Eloquent\Model;

class BillReceives extends Model
{
	protected $fillable = [
        'date_launch',
        'name',
        'value',
        'user_id'
    ];
}