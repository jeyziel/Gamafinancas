<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 11/01/18
 * Time: 16:22
 */

namespace GAMAFin\Plugin;

use GAMAFin\ServiceContainerInterface;


interface PluginInterface
{
    public function register(
        ServiceContainerInterface $serviceContainer
    );
}