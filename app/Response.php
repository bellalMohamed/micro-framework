<?php

namespace App;

class Response {
	protected $body;

	protected $statusCode = 200;

	protected $headers = [];

	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setStatus($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function withJson($body, $statusCode = 200)
	{
		$this->body = json_encode($body);
		$this->statusCode = $statusCode;
		
		$this->setHeader('Content-type', 'application/json');

		return $this;
	}

	public function setHeader($header, $value)
	{
		$this->headers[] = [$header, $value];
	}

	public function getHeaders()
	{
		return $this->headers;
	}
}