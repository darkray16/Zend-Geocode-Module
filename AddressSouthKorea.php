<?php

class Geocode_AddressSouthKorea extends Geocode_Address
{

	protected $_street;

	public function setStreet($street)
	{
		$this->_street_address = $street;
		return $this;
	}

	public function getStreet()
	{
		return $this->_street_address;
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

	public function setDistrict($district)
	{
		if (!empty($this->_sublocality))
		{
			$this->_sublocality .= ', ' . $district;
		} else
		{
			$this->_sublocality = $district;
		}
		return $this;
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
}
