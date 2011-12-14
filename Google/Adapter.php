<?php

class Geocode_Google_Adapter extends Geocode_AbstractAdapter
{
	protected $_localization; //e.g. 'USA', 'SouthKorea'

	public function __construct($localization) {
		//localize the terms for regions, e.g. states, prefecture, provinces
		$this->_localization = $localization;
	}
		
	protected function _getGeocodeUrl()
	{
		return 'http://maps.googleapis.com/maps/api/geocode/xml';
	}

	protected function _retrieveCoordinates(Geocode_Address $addressObj)
	{
		$addressStr = '';
		foreach($addressObj->getAddress() as $info)
		{
			$addressStr .= $info . ',';
		}

		$httpClient = new Zend_Http_Client();
		$httpClient->setUri($this->_getGeocodeUrl());
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

	protected function _retrieveAddress(Geocode_Coordinates $coordinatesObj)
	{
		$coordinatesStr = $coordinatesObj->getLatitude() . ',' .  $coordinatesObj->getLongitude();
		$httpClient = new Zend_Http_Client();
		$httpClient->setUri($this->_getGeocodeUrl());
		$httpClient->setParameterGet('latlng', $coordinatesStr)
			   ->setParameterGet('sensor', 'false');
		
		$response = $httpClient->request('GET');
		$xml = new SimpleXmlElement($response->getBody());
		
		//parse the xml and return an Address Obj
		if ($xml->status == 'OK' && !empty($xml->result))
		{
			$addressObj = Geocode_AddressFactory::getAddressInstance($this->_localization);
			foreach($xml->result as $result)
			{
				if ($result->type == 'street_address')
				{
					$addressObj->setStreet($result->formatted_address);
					foreach($result as $component)
					{
						$addressObj->set($component->type, $component->long_name);
					}
				}
			}

			return $addressObj;
		}
	}
}
