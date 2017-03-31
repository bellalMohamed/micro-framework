<?php

require 'vendor/autoload.php';
use App\App;

$app = new App();
$container = $app->getContainer();

$container['errorHandler'] = function () {
	return function ($response) {
		$response->setStatus('404');
	};
};

$container['config'] = function () {
	return [
		'db_driver' => 'mysql',
		'db_host' => 'localhost',
		'db_name' => 'miniframework',
		'db_user' => 'root',
		'db_pass' => 'root',
	];
};

$container['db'] = function ($c) {
	return new PDO("{$c->config['db_driver']}:host={$c->config['db_host']};dbname={$c->config['db_name']}", $c->config['db_user'], $c->config['db_pass']);
};

$app->get('/home', function () {
	echo 'Home :D :D ';
});

$app->get('/users', [\App\Controllers\UserController::class, 'index']);

$app->run();
