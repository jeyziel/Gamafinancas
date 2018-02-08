<?php declare(strict_types=1);

namespace GAMAFin\View;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

interface ViewRenderInterface
{
    public function render(string $path, array $context = []) : ResponseInterface;
}