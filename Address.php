<?php
/**
 * This file contains the Geocode_Address class.
 * 
 * @author Raymond Cheung
 * @package Geocode
 * @since Version 0.1
 */
 

/**
 * Stores address information, to be used to pass to 
 * adapters to retireve information or created by adapters
 * to store geocode response info.
 */
class Geocode_Address {

	/**
	 * The different types of address information
	 * found in this address, e.g. town, county, prefecture.
	 * This is populated as the API call for getAddress is parsed.
	 * 
	 * @access protected
	 * @var array
	 */
	protected $_types = array();
	
	/**
	 * Stores all the address information in one location. Only 
	 * accessed by setters/getters methods or reset method.
	 * 
	 * @access protected
	 * @var array
	 */
	protected $_data = array();
	
	/**
	 * Stores the entire address as single string.
	 * 
	 * @access protected
	 * @var string
	 */
	protected $_unformattedAddress;
	
	/**
	 * As API call response is parsed, sets of key value data pairs are parsed
	 * and stored in this object.  the name of the keys depends on the region,
	 * e.g. Canada has provinces, the USA has states, and Japan has prefectures.
	 * 
	 * @param string $property the name of the address type(see types property
	 * 						   for explanation of what types means)
	 * @param string $value the value for the address, e.g. if type is 
	 * 						   city, then value could be New York
	 * 
	 * @return Geocode_Address returned to allow fluent interface
	 */
	public function set($property, $value)
	{
		$this->_data[$property] = $value;
		$this->_types[] = $property;
		return $this;
	}

	/**
	 * Retrieve stored data regarding address.  The property name can be
	 * obtained by using getFormats, and passing the array values as 
	 * parameter to this function.
	 * 
	 * @param string $property the address information type(e.g. street,
	 * 						   state, province).
	 * 
	 * @return string the value for the address type passed.
	 */
	public function get($property)
	{
		return $this->_data[$property];
	}

	/**
	 * Returns a list of all address types that have been set. To be used
	 * with $this->get, as the elements returned are the strings that must be
	 * passed to $this->get
	 * 
	 * @return array list of all the addres types of the address data stored
	 */
	public function getFormats()
	{
		return $this->_types;
	}

	/**
	 * Set the raw entire address string that was parsed from API call response.
	 * 
	 * @param string $unformattedAddress full address as single string
	 * 
	 * @return Geocode_Address returns self for fluent interface
	 */
	public function setUnformattedAddress($unformattedAddress)
	{
		$this->_unformattedAddress = $unformattedAddress;
		return $this;
	}
	
	/**
	 * Get the entire address as single string. Address data type is lost in this
	 * form, meaning it's unkown which part of the data if any of it is the "city",
	 * "street", "province", etc.
	 * 
	 * @return string the entire address without address types
	 */
	public function getUnformattedAddress()
	{
		return $this->_unformattedAddress = $unformattedAddress;
	}
	
	/**
	 * Clears all stored data about address and address types.
	 * 
	 * @return Geocode_Address returns self for fluent interface
	 */
	public function reset() 
	{
		$this->_types = array();
		$this->_data = array();
		
		return $this;
	}
}
