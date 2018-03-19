<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/statements', function (ServerRequestInterface $request) use($app) {

    $view = $app->service('view.renderer');
    $data = $request->getQueryParams();

    $dateStart = $data['date_start'] ?? (new \DateTime())->modify('-1 month');
    $dateEnd = $data['date_end'] ?? new \DateTime();

    $dateStart = $dateStart instanceof \DateTime ? $dateStart->format('Y-m-d')
        : \DateTime::createFromFormat('d/m/Y', $dateStart)->format('Y-m-d');

    $dateEnd = $dateEnd instanceof \DateTime ? $dateEnd->format('Y-m-d')
        : \DateTime::createFromFormat('d/m/Y', $dateEnd)->format('Y-m-d');

    return $view->render('statements');
}, 'statements.list');