<?php

class Geocode_Address {

	public function set($property, $value)
	{
		$property = '_' . $property;
		$this->$property = $value;
		return $this;
	}

	public function get($property)
	{
		$property = '_' . $property;
		return $this->$property;
	}
}
