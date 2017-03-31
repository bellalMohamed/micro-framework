<?php

namespace App;

use App\Exceptions\MethodNotAllowedExeption;
use App\Exceptions\RouteNotFoundExeption;

class Router {
	/**
	 * Routing path
	 * @var int/str
	 */
	protected $path;
	/**
	 * Routes array
	 * @var array
	 */
	protected $routes = [];
	/**
	 * Methods array
	 * @var array
	 */
	protected $methods = [];

	/**
	 * Set path
	 * @param string $path
	 */
	public function setPath($path = '/') 
	{
		$this->path = $path;
	}

	/**
	 * Add route
	 * @param mixed $uri
	 * @param closuer/obj $handler
	 * @param array  $methods
	 */
	public function addRoute($uri, $handler, array $methods)
	{
		$this->routes[$uri] = $handler;
		$this->methods[$uri] = $methods;
	}

	/**
	 * get response
	 * @return OBJ/Closuere
	 */
	public function getResponse()
	{
		if ($this->routes[$this->path] === null) {
			throw new RouteNotFoundExeption("Route Not Found");
		}

		if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
			die('Wrong Method Exception');
		}
		return $this->routes[$this->path];
	}

}