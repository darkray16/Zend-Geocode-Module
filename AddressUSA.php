<?php

class Geocode_AddressUSA extends Geocode_Address{

	protected $_street = array();

	public function setStreetName($streetName)
	{
		$this->_street[2] = $streetName;
		return $this;
	}

	public function setStreetNumber($streetNumber)
	{
		$this->_street[1] = $streetNumber;
		return $this;
	}

	public function setStreet($street)
	{
		$this->_street[0] = $street;
		return $this;
	}

	public function getStreet()
	{
		return $this->_street_number . ' ' . $this->_route;
	}

	public function setCity($city)
	{
		$this->_locality = $city;
		return $this;
	}

	public function getCity()
	{
		return $this->_locality;
	}	

	public function setState($state)
	{
		$this->_administrative_area_level_1 = $state;
		return $this;
	}

	public function getState()
	{
		return $this->_administrative_area_level_1;
	}

	public function setCountry($country)
	{
		$this->_country = $country;
		return $this;
	}

	public function getCountry()
	{
		return $this->_country;
	}
	
	public function getAddress()
	{
		//this must be redfined to support change in locality city, state, prefecture, etc.
		return array(
			"street" => implode('+', $this->_street),
			"city" => $this->_locality,
			"state" => $this->_administrative_area_level_1,
			"country" => $this->_country
		);
	}
	public function isComplete()
	{
		//ditto
		$data = get_object_vars($this);
		foreach($data as $key => $value) {
			if ($value === NULL && $key != "zipcode") {
				return false;
			}
		}
		return true;
	}
}
