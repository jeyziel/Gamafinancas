<?php

namespace GAMAFin\Models;

use GAMAFin\Models\CategoryCost;
use Illuminate\Database\Eloquent\Model;

class BillPays extends Model
{
    protected $fillable = [
        'name',
        'date_launch',
        'value',
        'user_id',
        'category_cost_id'
    ];


    public function categoryCost()
    {
        return $this->belongsTo(CategoryCost::class);
    }

}
