<?php

namespace App;
use ArrayAccess;

class Container implements ArrayAccess{

	/**
	 * items aray
	 * @var array
	 * @access protected
	 */
	protected $items = [];

	/**
	 * cache offsets to optimize
	 * @var array
	 * @access protected
	 */
	protected $cache = [];

	public function __construct(array $items)
	{
		foreach ($items as $offset => $value) {
			$this->offsetSet($offset, $value);
		}
	}

	/**
	 * set offset
	 * @param  string $offset
	 * @param  closure $value 
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->items[$offset] = $value;
	}

	/**
	 * get offset closue
	 * @param  [type] $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		if (!$this->has($offset)) {
			return null;
		}

		if (isset($this->cache[$offset])) {
			return $this->cache[$offset];
		}

		$item = $this->items[$offset]($this);
		
		$this->cache[$offset] = $item;
		
		return $item;
	}

	/**
	 * Unset Offset
	 * @param  string $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		if ($this->has($offset)) {
			unset($this->items[$offset]);
		}
	}

	/**
	 * check if offset exists
	 * @param  string $offset
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return isset($this->items[$offset]);
	}

	/**
	 * check if container has offset
	 * @param  string  $offset
	 * @return boolean
	 */
	public function has($offset)
	{
		return $this->offsetExists($offset);
	}

	/**
	 * __get Magic, handle array like to  property like
	 * @param  string $property
	 * @return mixed
	 */
	public function __get($property)
	{
		return $this->offsetGet($property);
	}
}