<?php

namespace App;

class Response {
	protected $body;

	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}
}