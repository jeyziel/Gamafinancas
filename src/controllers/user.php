<?php


use GAMAFin\Models\CategoryCost;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/users', function() use($app) {
    /**
     * @var $repository \GAMAFin\Repository\DefaultRepository
     */
    $repository = $app->service('users.repository');
    $users = $repository->all();

    $view = $app->service('view.renderer');
    return $view->render('users/list', compact('users'));
}, 'users.list');

$app->get('/users/new', function() use ($app){
    $view = $app->service('view.renderer');
    return $view->render('users/create');
}, 'users.new');

$app->post('/users/store', function(ServerRequestInterface $request) use($app){
    $repository = $app->service('users.repository');
    $data = $request->getParsedBody();
    $repository->create($data);
    return $app->route('users.list');
});

$app->get('/users/{id}/edit', function(ServerRequestInterface $request) use($app){
    $view = $app->service('view.renderer');
    $id = $request->getAttribute('id');

    $repository = $app->service('users.repository');
    $user = $repository->find($id);

    return $view->render('users/edit',compact('user'));
}, 'users.edit');

$app->post('/users/{id}/update', function(ServerRequestInterface $request) use($app){
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $repository = $app->service('users.repository');
    $repository->update($id, $data);
    return $app->route('users.list');
}, 'users.update');

$app->get('/users/{id}/delete', function(ServerRequestInterface $request) use($app){
    $id = $request->getAttribute('id');
    $repository = $app->service('users.repository');
    $repository->delete($id);
    return $app->route('users.list');
}, 'users.delete');


