<?php
/**
 * This file contains the Geocode_GeocodeAdapterFactory class.
 * 
 * @author Raymond Cheung
 * @package Geocode
 * @since Version 0.1
 */
 

/**
 * Returns adapter necessary for geocode lookup.  Used by Geocoder class
 * to fulfill lookup requests.  Not intended to be used by user.
 */
class Geocode_GeocodeAdapterFactory
{
	
	/**
	 * The desired geocoding service is specified here.
	 * 
	 * @param string $adapter the API service to use, valid values:
	 * 						  'google', 'bing'
	 * @todo implement Bing adapter
	 * @return Adapter the adapter to use to connecto to geocode service
	 */
	static public function getAdapter($adapter)
	{
		switch (strtolower($adapter)) {
			case 'google' :
				return new Geocode_Google_Adapter();
				break;
			default:
				throw new Exception('Uknown adapter name supplied');
		}
	}
}
