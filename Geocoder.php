<?php

class Geocode_Geocoder 
{
	
	protected $_geocodeAdapter;
	protected $_address;
	protected $_coordinates;
	
	/*
	 * Specific API to use for geolocation, string
	 */

	public function __construct($adapter, $localization=null)
	{
		$this->_geocodeAdapter = Geocode_GeocodeAdapterFactory::getAdapter($adapter, $localization);
	}

	public function setAddress(Geocode_Address $address)
	{
		$this->_address = $address;
	}

	public function getAddress()
	{
		return $this->_address;
	}

	public function setCoordinates(Geocode_Coordinates $coordinates)
	{
		$this->_coordinates = $coordinates;
	}

	public function getCoordinates()
	{
		return $this->_coordinates;
	}

	//API call to retrieve address
	public function retrieveAddress()
	{
		if ($this->_coordinates === null) {
			throw new Exception('Coordinates not set.');
		}
		return $this->_geocodeAdapter->getAddress($this->_coordinates);
	}

	//API call to retrieve coordinates
	public function retrieveCoordinates()
	{
		if ($this->_address === null) {
			throw new Exception('Address not set.');
		}
		return $this->_geocodeAdapter->getCoordinates($this->_address);
	}
}
