<?php

namespace App;
use App\Container;
use App\Exceptions\RouteNotFoundExeption;
use App\Response;
use App\Router;

class App {
	/**
	 * container OBJ holder
	 * @var OBJ
	 * @access protected
	 */
	protected $container;

	/**
	 * construct new cantainer class
	 */
	public function __construct()
	{
		$this->container = new Container([
			'router' => function () {
				return new Router;
			},
			'response' => function () {
				return new Response;
			}
		]);
	}

	/**
	 * return container class
	 * @return App\Container
	 */
	public function getContainer()
	{
		return $this->container;
	}

	/**
	 * add get method route
	 * @param  mixed $uri
	 * @param  mixed $handler
	 * @return void
	 */
	public function get($uri, $handler)
	{
		$this->container->router->addRoute($uri, $handler, ['GET']);
	}

	/**
	 * add post methods route
	 * @param  mixed $uri
	 * @param  mixed $handler
	 * @return void
	 */
	public function post($uri, $handler)
	{
		$this->container->router->addRoute($uri, $handler, ['POST']);
	}

	/**
	 * Add single/multiable methods to one route
	 * @param  mixed $uri
	 * @param  mixed $handler
	 * @param  array  $methods
	 * @return void
	 */
	public function map($uri, $handler, array $methods = ['GET'])
	{
		$this->container->router->addRoute($uri, $handler, $methods);
	}

	/**
	 * run the app, apply routes
	 * @return mixed
	 */
	public function run()
	{
		$router = $this->container->router;
		$router->setPath($_SERVER['PATH_INFO'] ?? '/');
		try {
			$response = $router->getResponse();
		} catch (RouteNotFoundExeption $e) {
			if ($this->container->has('errorHandler')) {
				$response = $this->container->errorHandler;
			} else {
				return ;
			}
		}

		return $this->respond($this->process($response));
	}

	/**
	 * Process responses
	 * @param  mixed $callable
	 * @return closure
	 */
	protected function process($callable)
	{
		$response = $this->container->response;
		if (is_array($callable)) {
			if (!is_object($callable[0])) {
				$callable[0] = new $callable[0];
			}
			return call_user_func($callable, $response);
		}
		return $callable($response);
	}

	/**
	 * Handle responds
	 * @param  mixed $response
	 * @return mixed
	 */
	protected function respond($response)
	{
		header(sprintf(
			'HTTP/%s %s %s',
			'1.1',
			$response->getStatusCode(),
			''
		));

		if (!$response instanceof Response) {
			echo $response;
			return;
		}

		foreach ($response->getHeaders() as $header) {
			header($header[0] . ': ' . $header[1]);
		}

		echo $response->getBody();
	}
}