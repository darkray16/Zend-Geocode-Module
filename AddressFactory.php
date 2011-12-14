<?php

class Geocode_AddressFactory
{

	static function getAddressInstance($localization=null)
	{
		if (!empty($localization))
		{
			$addressType = 'Geocode_Address' . $localization;
		} else
		{
			$addressType = 'Geocode_Address';
		}
		try
		 {
			$instance = new $addressType;
		} catch (Exception  $e) 
		{
			throw new Exception('Unsupported format supplied to localization');
		}
		return $instance;
	}
}

