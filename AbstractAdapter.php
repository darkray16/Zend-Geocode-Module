<?php

abstract class Geocode_AbstractAdapter
{

	public function getCoordinates(Geocode_Address $address)
	{
		//implementation of API call left up to child class
		return $this->_retrieveCoordinates($address);
	}

	public function getAddress(Geocode_Coordinates $coordinates)
	{
		return $this->_retrieveAddress($coordinates);
	}
}
