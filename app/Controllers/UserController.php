<?php

namespace App\Controllers;
use App\Models\User;
use \PDO;

class UserController {
	/**
	 * PDO database OJJ
	 * @var \PDO
	 */
	protected $db;

	/**
	 * init db OBJ
	 * @param PDO $db
	 */
	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	/**
	 * test json response
	 * @param  App/Response $response
	 * @return json
	 */
	public function index($response)
	{
		return $response->withJson([
			'error' => false,
		]);
	}

	/**
	 * test db, models
	 * @param  App\Reposponse $response
	 * @return json
	 */
	public function users($response)
	{
		$users = $this->db->query('SELECT * FROM users')->fetchAll(PDO::FETCH_CLASS, User::class);
		return $response->withJson($users);
	}
}
