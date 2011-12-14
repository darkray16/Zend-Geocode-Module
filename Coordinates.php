<?

class Geocode_Coordinates
{

	protected $_coordinates = array();

	public function setCoordinates(array $coordinates)
	{
		if (!array_key_exists('lat', $coordinates) && !array_key_exists('lng', $coordinates))
		{
			throw new Exception('Coordinates passed is missing long and lat keys');
		}

		//don't want to copy any other extraneous array elements
		$this->_coordinates['lat'] = $coordinates['lat'];
		$this->_coordinates['lng'] = $coordinates['lng'];
		return $this;
	}
	
	public function setLatitude($latitude)
	{
		$this->_coordinates['lat'] = $latitude;
		return $this;
	}

	public function setLongitude($longitude)
	{
		$this->_coordinates['lng'] = $longitude;
		return $this;
	}
	
	public function getLatitude()
	{
		return $this->_coordinates['lat'];
	}

	public function getLongitude()
	{
		return $this->_coordinates['lng'];
	}

	public function getCoordinates()
	{
		return $this->_coordinates;
	}
}
