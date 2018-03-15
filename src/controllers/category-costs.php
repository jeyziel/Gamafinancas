<?php

use GAMAFin\Models\CategoryCost;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/category-costs', function() use($app) {
     /**
     * @var $repository \GAMAFin\Repository\DefaultRepository
     */
    $auth = $app->service('auth');
    $repository = $app->service('category-costs.repository');
    $categories = $repository->findByField('user_id', $auth->user()->getId());

    $user = $app->service('auth');

    $view = $app->service('view.renderer');
    return $view->render('category-costs/list', compact('categories'));
}, 'category-costs.list');

$app->get('/category-costs/new', function() use ($app){
    $view = $app->service('view.renderer');
    return $view->render('category-costs/create');
}, 'category-costs.new');

$app->post('/category-costs/store', function(ServerRequestInterface $request) use($app){
    $auth = $app->service('auth');
    $repository = $app->service('category-costs.repository');
    $data = $request->getParsedBody();
    $data['user_id'] = $auth->user()->getId();
    $repository->create($data);
    return $app->route('category-costs.list');
});

$app->get('/category-costs/{id}/edit', function(ServerRequestInterface $request) use($app){
    $view = $app->service('view.renderer');
    $id = $request->getAttribute('id');

    $repository = $app->service('category-costs.repository');
    $category = $repository->find($id);

    return $view->render('category-costs/edit',compact('category'));
}, 'category-costs.edit');

$app->post('/category-costs/{id}/update', function(ServerRequestInterface $request) use($app){
  $id = $request->getAttribute('id');

  $auth = $app->service('auth');

  $data = $request->getParsedBody();
  $data['user_id'] = $auth->user()->getId();

  $repository = $app->service('category-costs.repository');
  $repository->update($id, $data);
  return $app->route('category-costs.list');
}, 'category-costs.update');

$app->get('/category-costs/{id}/delete', function(ServerRequestInterface $request) use($app){
    $id = $request->getAttribute('id');
    $category = CategoryCost::findOrFail($id);
    $category->delete();
    return $app->route('category-costs.list');
}, 'category-costs.delete');



