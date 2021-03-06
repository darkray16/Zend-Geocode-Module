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
	 * Stores all adapters passed by the user.  Coordinates/Address retrieval will
	 * loop through adapters until results are returned or all have been called.
	 * 
	 * @access protected
	 * @var array
	 */
	protected $_adapters = array();
	
	/**
	 * Push an adapter to an array of adapters which will be used to retrieve
	 * coordinates/address.
	 * 
	 * @access public
	 * @param Geocode_AdapterInterface $adapter the layer between this class
	 * 											and the actual web service api
	 * @return Geocode_Geocoder returns this for fluent interface
	 */
	public function addAdapter(Geocode_AdapterInterface $adapter) 
	{
		$this->_adapters[] = $adapter;
		return $this;
	}
	
	/**
	 * Clears out all adapters.  At least one more will need to be added before 
	 * calling geocoding methods(retrieveCoordinates, retrieveAddress).
	 */
	public function resetAdapters() 
	{
		$this->_adapters = array();
		return $this;
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
	 * Get first result for address lookup of geocode.  Loops through all 
	 * adapters added using addAdapters method until it can find coordinates. 
	 * Exception thrown if coordinate obj has not been set yet.
	 * 
	 * @access public
	 * @return Geocode_Address contains the address info for first result returned
	 * 						   by geocode lookup.
	 * @throws Exception if unable to retrieve address using all adapters.
	 * @todo return array of all addresses found at coordinate set, instead of
	 * 		 only the first result.
	 */
	public function retrieveAddress()
	{
		if ($this->_coordinates === null) {
			throw new Exception('Coordinates not set.');
		}
		
		$address = null;
		for($i=0, $length=count($this->_adapters); $i<$length; ++$i) {
			try {
				$address = $this->_adapters[$i]->getAddress($this->_coordinates);
			} catch (RequestFailed $e) {
				continue;
			}
		}
		
		if (!$address) {
			throw new Exception('Unable to retrieve address.');
		}
		return $address;
	}

	/**
	 * Get the coordinates(latitude, longitude) for coordinate lookup.  Loops 
	 * through all adapters added using addAdapters method until it can find
	 * coordinates. Exception thrown if address obj has not been set yet or 
	 * if address retrieval fails.
	 * 
	 * @access public
	 * @return Geocode_Coordinates contains coordinates for geocode lookup of
	 * 							   address that user has set.
	 * @throws Exception if unable to retrieve coordinates using all adapters.
	 */
	public function retrieveCoordinates()
	{
		if ($this->_address === null) {
			throw new Exception('Address not set.');
		}
		
		$coordinates = null;
		for($i=0,$length=count($this->_adapters); $i<$length;++$i) {
			try {
				$coordinates = $this->_adapters[$i]->getCoordinates($this->_address);
			} catch (RequestFailed $e) {
				continue;
			}
		}
		if (!$coordinates) {
			throw new Exception('Unable to retrieve coordinates.');
		}
		return $coordinates;
	}
}
