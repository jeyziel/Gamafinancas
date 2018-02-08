<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 05/02/18
 * Time: 22:27
 */

namespace GAMAFin\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
       'firs_name',
       'last_name',
       'email',
       'password',
    ];
}