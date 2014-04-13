<?php

// include the class file
include("classes/BrandingWebservice.php");

// instantiate brandingWebservice class
$brandingWebserviceObj = new BrandingWebservice(array(
	"allowed_methods" => array("GET")
));

// deliver response
$brandingWebserviceObj->deliverResponse();