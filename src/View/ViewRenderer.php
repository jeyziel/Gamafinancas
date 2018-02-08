<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 23/01/18
 * Time: 18:46
 */

namespace GAMAFin\View;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

class ViewRenderer implements ViewRenderInterface
{
    private $twigEnviroment;

    /**
     * ViewRenderer constructor.
     * @param \Twig_Environment $twigEnviroment
     */
    public function __construct(\Twig_Environment $twigEnviroment)
    {
        $this->twigEnviroment = $twigEnviroment;
    }

    public function render(string $path, array $context = []): ResponseInterface
    {

        $result = $this->twigEnviroment->render($path . '.html.twig', $context);
        $response = new Response();
        $response->getBody()->write($result);
        return $response;
    }
}