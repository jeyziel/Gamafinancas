<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 23/01/18
 * Time: 22:37
 */

namespace GAMAFin\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryCost extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];
}