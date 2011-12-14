<?php

class Geocode_GeocodeAdapterFactory
{

	static public function getAdapter($adapter, $localization)
	{
		switch (strtolower($adapter)) {
			case 'google' :
				return new Geocode_Google_Adapter($localization);
				break;
			default:
				throw new Exception('Uknown adapter name supplied');
		}
		
	}

}
