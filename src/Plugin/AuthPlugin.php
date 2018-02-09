<?php

namespace GAMAFin\Plugin;


use GAMAFin\Auth\JasnyAuth;
use GAMAFin\ServiceContainerInterface;
use Interop\Container\ContainerInterface;
use GAMAFin\Auth\Auth;

class AuthPlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $container->addLazy('jasny.auth', function (ContainerInterface $container) {
            return new JasnyAuth($container->get('users.repository'));
        });
        $container->addLazy('auth', function (ContainerInterface $container) {
            return new Auth($container->get('jasny.auth'));
        });
    }
}