<?php
$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/token', 'TokenController@getToken');