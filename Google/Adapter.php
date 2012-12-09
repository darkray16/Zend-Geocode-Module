<?php
/**
 * This file contains the Geocode_Google_Adapter class.
 * 
 * @author Raymond Cheung
 * @package Geocode
 * @since Version 0.1
 */
 
 /**
  * This connects the Geocoder with the Google Geocoding services.  To 
  * be called by the Geocoder class only.
  */
class Geocode_Google_Adapter implements Geocode_AdapterInterface
{
	/**
	 * The url for the Google Geocode web service.
	 * 
	 * @const string the url for Google geocode service.
	 */
	const GOOGLE_URL = 'http://maps.googleapis.com/maps/api/geocode/xml';
	
	/**
	 * Send a request to the Google Geocode web service to find coordinates for passed
	 * address.  Used by Geocoder class, not directly called by user.
	 * 
	 * @access public
	 * @param Geocode_Address $addressObj
	 * @return Geocode_Coordinates | null returns coordinates object if found 
	 */
	public function getCoordinates(Geocode_Address $addressObj)
	{
		$addressStr = '';
		foreach($addressObj->getAddress() as $info)
		{
			$addressStr .= $info . ',';
		}

		$httpClient = new Zend_Http_Client();
		$httpClient->setUri(self::GOOGLE_URL);
		$httpClient->setParameterGet('address', $addressStr)
		           ->setParameterGet('sensor', 'false');

		$response = $httpClient->request('GET');
		$xml = new SimpleXMLElement($response->getBody());
		

		//parse the xml and return a Location object
		if ($xml->status == "OK" && !empty($xml->result->geometry->location)) {
			$locationObj = new Geocode_Coordinates();
			$locationObj->setCoordinates(array(
				'lat' => $xml->result->geometry->location->lat,
				'lng' => $xml->result->geometry->location->lng
			));
			return $locationObj;
		}else
		{
			return null;
		}		    
	}

	/**
	 * Send a request to the Google Geocode web service to find street address for passed
	 * coordinates.  Used by Geocoder class, not directly called by user.
	 * 
	 * @access public
	 * @param Geocode_Coordinates $coordinatesObj
	 * @return Geocode_Address | null returns address object if found 
	 */
	public function getAddress(Geocode_Coordinates $coordinatesObj)
	{
		$coordinatesStr = $coordinatesObj->getLatitude() . ',' .  $coordinatesObj->getLongitude();
		$httpClient = new Zend_Http_Client();
		$httpClient->setUri(self::GOOGLE_URL);
		$httpClient->setParameterGet('latlng', $coordinatesStr)
			   ->setParameterGet('sensor', 'false');
		
		$response = $httpClient->request('GET');
		$xml = new SimpleXmlElement($response->getBody());
		
		//parse the xml and return an Address Obj
		if ($xml->status == 'OK' && !empty($xml->result))
		{
			$addressObj = new Geocode_Address();
			foreach($xml->result as $result)
			{
				if ($result->type == 'street_address')
				{
					$addressObj->setUnformattedAddress((string) $result->formatted_address);
					foreach($result as $component)
					{
						$addressObj->set((string) $component->type, $component->long_name);
					}
				}
			}

			return $addressObj;
		} else {
			return null;
		}
	}
}
