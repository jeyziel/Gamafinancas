<?php declare(strict_types=1);

namespace GAMAFin;

use GAMAFin\Plugin\PluginInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    private $serviceContainer;

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

    public function start(){
        $route = $this->service('route');
       // RequestInterface::class
        $request = $this->service(ServerRequestInterface::class);
    
        if(!$route){
            echo "Page not found";
            exit;
        }
    
        foreach ($route->attributes as $key => $value){
            $request = $request->withAttribute($key,$value);
        }

        $callable = $route->handler;
        $callable($request);
    }

    


}