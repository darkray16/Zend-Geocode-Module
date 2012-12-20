<?php
/**
 * This file contains the Geocode_Coordinates class.
 * 
 * @author Raymond Cheung
 * @package Geocode
 * @since Version 0.1
 */
 

/**
 * Data object for storage of latitude, longitude.  Use this to pass
 * coordinates to adapter for retrieval.  This is also the form in which
 * results are passed back from coordinates retrieval.
 */
class Geocode_Coordinates
{
	/**
	 * Stores the latitude, longitude.  Use keys 'lat', 'lng'.
	 * 
	 * @access protected
	 * @var array
	 */
	protected $_coordinates = array();

	/**
	 * Set both latitude and longitude coordinates.
	 * 
	 * @access public
	 * @param array $coordinates must contain 'lat', 'lng' keys with corresponding
	 * 							 float values
	 */
	public function setCoordinates(array $coordinates)
	{
		if (!array_key_exists('lat', $coordinates) 
			|| !array_key_exists('lng', $coordinates)) {
			$errorMsg = 'array passed to setCoordinates method is missing lng and lat keys';
			throw new Exception($errorMsg);
		}

		//don't want to copy any other extraneous array elements
		$this->_coordinates['lat'] = $coordinates['lat'];
		$this->_coordinates['lng'] = $coordinates['lng'];
		return $this;
	}
	
	/**
	 * Set latitude point.
	 * 
	 * @access public
	 * @param float $latitude
	 * @return Geocode_Coordinates return this for fluent interface
	 */
	public function setLatitude($latitude)
	{
		$this->_coordinates['lat'] = $latitude;
		return $this;
	}

	/**
	 * Set longitude point.
	 * 
	 * @access public
	 * @param float $longitude
	 * @return Geocode_Coordinates return this for fluent interface
	 */
	public function setLongitude($longitude)
	{
		$this->_coordinates['lng'] = $longitude;
		return $this;
	}
	
	/**
	 * Get latitude coordinate.
	 * 
	 * @access public
	 * @return int latitude
	 */
	public function getLatitude()
	{
		return $this->_coordinates['lat'];
	}

	/**
	 * Get longitude coordinate.
	 * 
	 * @access public
	 * @return int longitude
	 */
	public function getLongitude()
	{
		return $this->_coordinates['lng'];
	}

	
	/**
	 * Get latitude, longitude as array.
	 * 
	 * @access public
	 * @return array coordinates with 'lat', 'lng' keys
	 */
	public function getCoordinates()
	{
		if (!empty($this->_coordinates)) {
			return $this->_coordinates;
		} else {
			$errorMsg = 'getCoordinates called before coordinates values have been set';
			throw new Exception($errorMsg);
		}
	}
	
	/**
	 * Resets the coordinates array to empty array.
	 * 
	 * @access public
	 * @return Geocode_Coordinates return this for fluent interface
	 */
	public function reset()
	{
		$this->_coordinates = array();
		return $this;
	}
}
