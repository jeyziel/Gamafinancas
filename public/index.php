<?php 

use GAMAFin\Application;
use GAMAFin\ServiceContainer;
use GAMAFin\Plugin\RoutePlugin;
use Psr\Http\Message\RequestInterface;


require __DIR__ . "/../vendor/autoload.php";


$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);
$app->plugin(new RoutePlugin());


$app->get('/home/{id}/{name}', function(RequestInterface $request) {
    echo 'hello world';
    echo $request->getAttribute('id');
    echo $request->getAttribute('name');
});

$app->get('/home', function() {
    echo 'hello home';
});

$app->start();

