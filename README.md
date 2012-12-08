This library is a module that is usable with [Zend Framework 1](http://framework.zend.com/manual/1.12/en/introduction.html).  To add it to a site utilizing Zend Framework, add this folder, or a link to it in the webroot/library directory, where the Zend Framework itself is also found.  Next, you must add the line: 

"autoloaderNamespaces[] = Geocode_" 

to your application/config/application.ini file.  From there, most of the functions you need to make a simple geocode request can be found in Geocoder.php, Address.php, and Coordinates.php.  Reading through the documentation of these should give you the basics.

Zend-Geocode-Module is a module written by me that is free for use by anyone and is allowed to be modified and used by all.  I wrote this module because Zend Framework is missing a module for geocoding.  This geocoding module does use Google as of right now, but I plan to implement the option to use other Geocoding services, like Bing.

To see it in action, create the following files and content:

application/controllers/DemoController.php

class DemoController extends Zend_Controller_Action
{

  public function init()
  {
      /* Initialize action controller here */
  }
  
  public function indexAction()
  {
    $geocoder = new Geocode_Geocoder("google", "USA");
	  $coordinates = new Geocode_Coordinates();
	
	  $coordinates->setCoordinates(array('lat'=>38.286488,'lng'=>-107.578125));
	  $geocoder->setCoordinates($coordinates);
	  $address = $geocoder->retrieveAddress();
	  $this->view->address = $address;
  }
}


application/views/scripts/demo/index.phtml

<head>
    <title>Test Geocoding Page</title>
</head>

<body>
    <?php echo var_dump($this->address);?>
</body>