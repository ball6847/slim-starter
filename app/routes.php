<?php

$app->get('/{entity}[/]', 'Library\Controller\Restful:index');
$app->get('/{entity}/{id}[/]', 'Library\Controller\Restful:get');
$app->post('/{entity}[/]', 'Library\Controller\Restful:post');
$app->put('/{entity}/{id}[/]', 'Library\Controller\Restful:put');
$app->delete('/{entity}/{id}[/]', 'Library\Controller\Restful:delete');
