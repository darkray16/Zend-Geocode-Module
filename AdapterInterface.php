<?php
/**
 * This file contains the Geocode_AdapterInterface class.
 * 
 * @author Raymond Cheung
 * @package Geocode
 * @since Version 0.1
 */
 
/**
 * Adapters are connectors to various APIs on the internet that provide
 * geocoding services.
 * 
 */
interface Geocode_AdapterInterface
{

	/**
	 * Retrieve the latitude and longitude of a given address.
	 * 
	 * @access public
	 * @param Geocode_Address $addressObj the object that contains address info
	 * 
	 * @return Geocode_Coordinates	   the coordinates(latitude, longitude) 
	 * 								   of the address
	 */
	public function getCoordinates(Geocode_Address $addressObj);

	/**
	 * Retrieve the first returned address of a given coordinate.
	 * 
	 * There may be multiple addresses returned, but only the first address 
	 * returned by the API call is used, and the rest are discarded.
	 * 
	 * @access public
	 * @param Geocode_Coordinates $coordinatesObj the object that contains 
	 * 										   latitude	and longitude info
	 * 
	 * @return Geocode_Address				   the first address returned by
	 * 										   API call
	 * @todo return all addresses as array
	 */
	public function getAddress(Geocode_Coordinates $coordinatesObj);
}
