<?php declare (strict_types = 1);

namespace GamaFin\Plugin;


use GamaFin\ServiceContainer;
use Aura\Router\RouterContainer;
use GAMAFin\Plugin\PluginInterface;
use Psr\Http\Message\RequestInterface;
use GAMAFin\ServiceContainerInterface;
use Zend\Diactoros\ServerRequestFactory;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RoutePlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $routerContainer = new RouterContainer();
        /* Registrar as rotas da aplicação */
        $map = $routerContainer->getMap();
        /* Tem a função de identificar a rota que está sendo acessada */
        $matcher = $routerContainer->getMatcher();
        /* Tem a funão de gerar links com base nas rotas registradas*/
        $generator = $routerContainer->getGenerator();
        $request = $this->getRequest();

        $container->add('routing', $map);
        $container->add('routing.matcher', $matcher);
        $container->add('routing.generator', $generator);
        $container->add(ServerRequestInterface::class, $request);

        $container->addLazy('route', function (ContainerInterface $container) {
            $matcher = $container->get('routing.matcher');
            $request = $container->get(ServerRequestInterface::class);


            return $matcher->match($request);
        });

    }

    /**
     * @return RequestInterface
     */
    protected function getRequest(): ServerRequestInterface
    {
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }


}