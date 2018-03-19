<?php 

use GAMAFin\Application;
use GAMAFin\Models\CategoryCost;
use GAMAFin\Plugin\AuthPlugin;
use GAMAFin\Plugin\DbPlugin;
use GAMAFin\Plugin\ViewPlugin;
use GAMAFin\ServiceContainer;
use GAMAFin\Plugin\RoutePlugin;
use GAMAFin\View\ViewRenderer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;


require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../src/helpers.php";

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());


$app->get('/home/{id}/{name}', function(RequestInterface $request) {
    echo 'hello world';
    echo $request->getAttribute('id');
    echo $request->getAttribute('name');
});

//$app->get('/', function(ServerRequestInterface $request) use ($app)  {
//    $view = $app->service('view.renderer');
//    $name = 'jeyziel';
//    return $view->render('test', compact('name'));
//});

require_once __DIR__ . "/../src/controllers/category-costs.php";
require_once __DIR__ . "/../src/controllers/user.php";
require_once __DIR__ . "/../src/controllers/auth.php";
require_once __DIR__ . "/../src/controllers/bill-receives.php";
require_once __DIR__ . "/../src/controllers/bill-pays.php";
require_once __DIR__ . "/../src/controllers/statements.php";

$app->start();

