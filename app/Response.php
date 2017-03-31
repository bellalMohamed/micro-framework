<?php

namespace App;

class Response {
	/**
	 * respose body
	 * @var mixed
	 */
	
	protected $body;
	/**
	 * Status Code
	 * @var integer
	 */
	protected $statusCode = 200;

	/**
	 * headers
	 * @var array
	 */
	protected $headers = [];

	/**
	 * set response body
	 * @param mixed $body
	 */
	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	/**
	 * get body content
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * Set status code
	 * @param integer $statusCode
	 */
	public function setStatus($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * get status code
	 * @return integer
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * Hanlde Json responses
	 * @param  mixed  $body
	 * @param  integer $statusCode
	 * @return OBJ
	 */
	public function withJson($body, $statusCode = 200)
	{
		$this->body = json_encode($body);
		$this->statusCode = $statusCode;

		$this->setHeader('Content-type', 'application/json');

		return $this;
	}

	/**
	 * Set response header
	 * @param string $header
	 * @param string $value
	 */
	public function setHeader($header, $value)
	{
		$this->headers[] = [$header, $value];
		return $this;
	}

	/**
	 * get header
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}
}