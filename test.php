<?php

// Note this line needs to change if you don't use Composer:
// require('square-php-sdk/autoload.php');
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Square\SquareClient;

// dotenv is used to read from the '.env' file created for credentials
// $dotenv = Dotenv::create(dirname(__DIR__));
// $dotenv->load();

// The access token to use in all Connect API requests.
// Set your environment as *sandbox* if you're just testing things out.


class LocationInfo {
  // Initialize the Square client.
  var $currency;
  var $country;

  function __construct() {
    $access_token =  env('SQUARE_ACCESS_TOKEN');

    $this->square_client = new SquareClient([
      'accessToken' => $access_token,  
      'environment' => env('ENVIRONMENT')
    ]);
    $location = $this->square_client->getLocationsApi()->retrieveLocation(config('app.location_id'))->getResult()->getLocation();
    $this->currency = $location->getCurrency();
    $this->country = $location->getCountry();  
  }

  public function getCurrency() {
    return $this->currency;
  }

  public function getCountry() {
    return $this->country;
  }
}

//$location_info = new LocationInfo();

$locationid = config('app.location_id');
echo $locationid;
//print_r($location_info);

?>