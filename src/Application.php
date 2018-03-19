<?php declare(strict_types=1);

namespace GAMAFin;

use Aura\Router\Generator;
use Aura\Router\Route;
use GAMAFin\Plugin\PluginInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\SapiEmitter;

class Application
{
    private $serviceContainer;
    private $befores = [];

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }
    
    /**
    *@param string $name
    */
    public function service($name)
    {
        return $this->serviceContainer->get($name);
    }

    /**
     * @param string $name
     * @param $service
     */
    public function addService(string $name, $service): void
    {
        if (is_callable($service)) {
            $this->serviceContainer->addLazy($name, $service);
        } else {
            $this->serviceContainer->add($name, $service);
        }
    }

    /**
     * @param PluginInterface $plugin
     */
    public function plugin(PluginInterface $plugin): void
    {
        $plugin->register($this->serviceContainer);
    }

    public function get($path, $action, $name = null) : Application
    {   
        $routing = $this->service('routing');
        $routing->get($name, $path, $action);
        return $this;
    }

    public function post($path, $action, $name = null): Application
    {
        $routing = $this->service('routing');
        $routing->post($name, $path, $action);
        return $this;
    }

    public function start(){
        $route = $this->service('route');
       // RequestInterface::class
        /**
         * @var ServerRequestInterface $request
         */
        $request = $this->service(ServerRequestInterface::class);
    
        if(!$route){
            echo "Page not found";
            exit;
        }

        foreach ($route->attributes as $key => $value){
            $request = $request->withAttribute($key,$value);
        }

        $result = $this->runBefores();

        if($result) {
            $this->emitResponse($result);
            return;
        }

        $callable = $route->handler;

        $response = $callable($request);
        $this->emitResponse($response);
    }

    public function before(callable $callback) : Application
    {
        array_push($this->befores, $callback);
        return $this;
    }

    public function route(string $name, array $params = [])
    {
        /**
         * @var Generator $generator
         */
        $generator = $this->service('routing.generator');
        $path = $generator->generate($name, $params);
        return $this->redirect($path);
    }

    public function redirect(string $path)
    {
        return new RedirectResponse($path);
    }

    protected function runBefores() : ?ResponseInterface
    {
        foreach ($this->befores as $before) {
            $result = $before($this->service(ServerRequestInterface::class));
            if($result instanceof ResponseInterface) {
                return $result;
            }
        }
        return null;
    }

    protected function emitResponse(ResponseInterface $response)
    {
        $emmit = new SapiEmitter();
        $emmit->emit($response);
    }


}