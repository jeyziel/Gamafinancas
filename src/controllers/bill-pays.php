<?php


use GAMAFin\Models\CategoryCost;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/bill-pays', function() use($app) {
     /**
     * @var $repository \GAMAFin\Repository\DefaultRepository
     */
    $auth = $app->service('auth');

    $repository = $app->service('bill-pays.repository');
    $bills = $repository->findByField('user_id', $auth->user()->getId());

    $user = $app->service('auth');

    $view = $app->service('view.renderer');
    return $view->render('bill-pays/list', compact('bills'));
}, 'bill-pays.list');

$app->get('/bill-pays/new', function() use ($app) {
    
    $categoryRepository = $app->service('category-costs.repository');
    $auth = $app->service('auth');
    $categories = $categoryRepository->findByField('user_id', $auth->user()->getId());

    $view = $app->service('view.renderer');
    return $view->render('bill-pays/create', compact('categories'));
}, 'bill-pays.new');

$app->post('/bill-pays/store', function(ServerRequestInterface $request) use($app){

    $auth = $app->service('auth');
    $repository = $app->service('bill-pays.repository');

    $categoryRepository = $app->service('category-costs.repository');

    $data = $request->getParsedBody();
    $data['user_id'] = $auth->user()->getId();
    $data['date_launch'] = dateParse($data['date_launch']);
    $data['value'] = numberParse($data['value']);

    $data['category_cost_id'] = $categoryRepository->findOneBy(
        [
            'id' => $data['category_cost_id'],
            'user_id' => $auth->user()->getId()
        ]
    )->id;

  
    $repository->create($data);
    
    return $app->route('bill-pays.list');
},'bill-pays.store');

$app->get('/bill-pays/{id}/edit', function(ServerRequestInterface $request) use($app){

    $auth = $app->service('auth');

    $view = $app->service('view.renderer');
    $id = $request->getAttribute('id');

    $repository = $app->service('bill-pays.repository');
    $categoryRepository = $app->service('category-costs.repository');

    $categories = $categoryRepository->findByField('user_id', $auth->user()->getId());


    $bill = $repository->find($id);


    return $view->render('bill-pays/edit',compact('bill', 'categories'));
}, 'bill-pays.edit');

$app->post('/bill-pays/{id}/update', function(ServerRequestInterface $request) use($app){

  $id = $request->getAttribute('id');
  $categoryRepository = $app->service('category-costs.repository');

  $auth = $app->service('auth');

  $data = $request->getParsedBody();
  $data['user_id'] = $auth->user()->getId();
  $data['date_launch'] = dateParse($data['date_launch']);
  $data['value'] = numberParse($data['value']);

  $data['category_cost_id'] = $categoryRepository->findOneBy(
        [
            'id' => $data['category_cost_id'],
            'user_id' => $auth->user()->getId()
        ]
  )->id;

  $repository = $app->service('bill-pays.repository');
  $repository->update($id, $data);
  return $app->route('bill-pays.list');
}, 'bill-pays.update');

$app->get('/bill-pays/{id}/delete', function(ServerRequestInterface $request) use($app){
    $id = $request->getAttribute('id');
    $repository = $app->service('bill-pays.repository');
    $repository->delete($id);
    return $app->route('bill-pays.list');
}, 'bill-pays.delete');


