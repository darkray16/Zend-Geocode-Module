<?php
/**
 * This file contains the Geocode_Geocoder class.
 * 
 * @author Raymond Cheung
 * @package Geocode
 * @since Version 0.1
 */
 

/**
 * Contains all methods required to carry out geocoding lookup
 * tasks.  This class is the one that should be used by the
 * user to interact with services in this module.
 */
class Geocode_Geocoder 
{
	/**
	 * This is set by the constructed using the string passed to
	 * choose the correct adapter.
	 * 
	 * @access protected
	 * @var AbstractAdapter
	 */
	protected $_geocodeAdapter;
	
	/**
	 * Store the passed address object which contains all address information.
	 * 
	 * @access protected
	 * @var Geocode_Address
	 */
	protected $_address;
	
	/**
	 * Store the passed coordinates(latitude, longitude) object which contains
	 * all coordinate information. 
	 * 
	 * @access protected
	 * @var Geocode_Coordinates
	 */
	protected $_coordinates;
	
	/**
	 * Constructor... 
	 * 
	 * @access public
	 * @param string @adapter the specific web service to use, valid values:
	 * 						  "google", "bing"
	 */
	public function __construct($adapter)
	{
		$this->_geocodeAdapter = Geocode_GeocodeAdapterFactory::getAdapter($adapter);
	}

	/**
	 * Set populated address obj to use with requestCoordinates method.
	 * 
	 * @access public
	 * @param Geocode_Address $address set a populated address obj
	 */
	public function setAddress(Geocode_Address $address)
	{
		$this->_address = $address;
	}

	/**
	 * Get the address object set by user that is used for coordinates retrieval. The
	 * address results are truend by retrieveCoordinates method, not this.
	 * 
	 * @access public
	 * @return Geocode_Address 
	 */
	public function getAddress()
	{
		return $this->_address;
	}
	
	/**
	 * Set the coordinates to be used in address retrieval.
	 * 
	 * @access public
	 * @param Geocode_Coordinates $coordinates latitude, longitude to use for
	 * 										   address retrieval.
	 */
	public function setCoordinates(Geocode_Coordinates $coordinates)
	{
		$this->_coordinates = $coordinates;
	}

	/**
	 * Get the coordinates set by user.  Used for address retrieval.  The coordinates
	 * results are returned by retrieveAddress method, not this.
	 * 
	 * @access public
	 * @return Geocode_Coordinates the coordinates set by the user.
	 */
	public function getCoordinates()
	{
		return $this->_coordinates;
	}

	/**
	 * Get first result for address lookup of geocode.  Exception thrown if coordinate
	 * obj has not been set yet.
	 * 
	 * @access public
	 * @return Geocode_Address contains the address info for first result returned
	 * 						   by geocode lookup.
	 * @todo return array of all addresses found at coordinate set, instead of
	 * 		 only the first result.
	 */
	public function retrieveAddress()
	{
		if ($this->_coordinates === null) {
			throw new Exception('Coordinates not set.');
		}
		return $this->_geocodeAdapter->getAddress($this->_coordinates);
	}

	/**
	 * Get the coordinates(latitude, longitude) for coordinate lookup.  Exception
	 * thrown if address obj has not been set yet.
	 * 
	 * @access public
	 * @return Geocode_Coordinates contains coordinates for geocode lookup of
	 * 							   address that user has set.
	 */
	public function retrieveCoordinates()
	{
		if ($this->_address === null) {
			throw new Exception('Address not set.');
		}
		return $this->_geocodeAdapter->getCoordinates($this->_address);
	}
}
