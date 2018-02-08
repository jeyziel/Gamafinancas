<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 05/02/18
 * Time: 19:35
 */

namespace GAMAFin\Repository;


class RepositoryFactory
{
    /**
     * @param $modelClass
     * @return DefaultRepository
     */
    public static function factory($modelClass)
    {
        return new DefaultRepository($modelClass);
    }
}