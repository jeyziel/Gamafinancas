<?php

use GAMAFin\Application;
use GAMAFin\Plugin\AuthPlugin;
use GAMAFin\Plugin\DbPlugin;
use GAMAFin\ServiceContainer;

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

return $app;