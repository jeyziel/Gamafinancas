<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 23/01/18
 * Time: 20:08
 */

namespace GAMAFin\Plugin;


use GAMAFin\Models\CategoryCost;
use GAMAFin\Models\User;
use GAMAFin\Repository\RepositoryFactory;
use GAMAFin\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Interop\Container\ContainerInterface;

class DbPlugin implements PluginInterface
{

    public function register(
        ServiceContainerInterface $container
    )
    {
        $capsule = new Capsule();
        $config = include __DIR__ . '/../../config/db.php';
        $capsule->addConnection($config['development']);
        $capsule->bootEloquent();

        $container->add('repository.factory', new RepositoryFactory());
        $container->addLazy('category-costs.repository', function (ContainerInterface $container) {
            return $container->get('repository.factory')->factory(CategoryCost::class);
        });
        $container->add('users.repository', function(ContainerInterface $container){
           return $container->get('repository.factory')->factory(User::class);
        });


    }
}