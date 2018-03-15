<?php


use GAMAFin\Models\CategoryCost;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/bill-receives', function() use($app) {
     /**
     * @var $repository \GAMAFin\Repository\DefaultRepository
     */
    $auth = $app->service('auth');

    $repository = $app->service('bill-receives.repository');
    $bills = $repository->findByField('user_id', $auth->user()->getId());

    $user = $app->service('auth');

    $view = $app->service('view.renderer');
    return $view->render('bill-receives/list', compact('bills'));
}, 'bill-receives.list');

$app->get('/bill-receives/new', function() use ($app){
    $view = $app->service('view.renderer');
    return $view->render('bill-receives/create');
}, 'bill-receives.new');

$app->post('/bill-receives/store', function(ServerRequestInterface $request) use($app){
    $auth = $app->service('auth');
    $repository = $app->service('bill-receives.repository');
    $data = $request->getParsedBody();
    $data['user_id'] = $auth->user()->getId();
    $data['date_launch'] = dateParse($data['date_launch']);
    $data['value'] = numberParse($data['value']);
    $repository->create($data);
    return $app->route('bill-receives.list');
},'bill-receives.store');

$app->get('/bill-receives/{id}/edit', function(ServerRequestInterface $request) use($app){
    $view = $app->service('view.renderer');
    $id = $request->getAttribute('id');

    $repository = $app->service('bill-receives.repository');
    $bill = $repository->find($id);


    return $view->render('bill-receives/edit',compact('bill'));
}, 'bill-receives.edit');

$app->post('/bill-receives/{id}/update', function(ServerRequestInterface $request) use($app){
  $id = $request->getAttribute('id');

  $auth = $app->service('auth');

  $data = $request->getParsedBody();
  $data['user_id'] = $auth->user()->getId();
  $data['date_launch'] = dateParse($data['date_launch']);
  $data['value'] = numberParse($data['value']);

  $repository = $app->service('bill-receives.repository');
  $repository->update($id, $data);
  return $app->route('bill-receives.list');
}, 'bill-receives.update');

$app->get('/bill-receives/{id}/delete', function(ServerRequestInterface $request) use($app){
    $id = $request->getAttribute('id');
    $repository = $app->service('bill-receives.repository');
    $repository->delete($id);
    return $app->route('bill-receives.list');
}, 'bill-receives.delete');


