<?php

namespace App;

use App\Exceptions\MethodNotAllowedExeption;
use App\Exceptions\RouteNotFoundExeption;

class Router {
	protected $path;
	protected $routes = [];
	protected $methods = [];

	public function setPath($path = '/') 
	{
		$this->path = $path;
	}

	public function addRoute($uri, $handler, array $methods)
	{
		$this->routes[$uri] = $handler;
		$this->methods[$uri] = $methods;
	}

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