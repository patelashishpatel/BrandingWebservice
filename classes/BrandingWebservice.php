<?php

/**
 * 	This class handles request for university branding and returns appropriate response
 * 	Author: Ashish R Patel
 */
Class BrandingWebservice {

    // properties
    private $_config = "";
    private $_universities = array(
        "engage" => array(
            "name" => "Engage University is an online learning resource for DotNetNuke, offering web-based, self-paced DNN training.",
            "logo" => "http://www.engageuniversity.com/Portals/0/Skins/logo.gif",
            "url" => "http://www.engageuniversity.com/"
        )
    );
    private $_httpResponseCodes = array(
        200 => 'OK',
        404 => 'Invalid Request',
        405 => 'Method Not Allowed'
    );

    // methods
    public function __construct($config) {
        $this->_config = $config;
    }

    public function deliverResponse() {
        // default response
        $response = null;

        // set content type header
        header("Content-Type:application/json");

        // check if the request method is allowed or not
        $status = $this->_validateRequestMethod();

        // set HTTP response status header
        header("HTTP/1.1 $status {$this->_httpResponseCodes[$status]}");

        // now lets process the request
        $response = $this->processRequest();

        // encode response to json
        $jsonData = json_encode($response);

        // lets expend the webservice to implement JSONP request
        if (isset($_GET['callback'])) {
            // jsonp response
            echo $_GET['callback']."(".$jsonData.")";
        } else {
            // json response
            echo $jsonData;
        }
    }

    protected function processRequest() {

        return (isset($this->_universities[$_GET['name']])) ? $this->_universities[$_GET['name']] : null;
    }

    private function _validateRequestMethod() {
        if (in_array($_SERVER['REQUEST_METHOD'], $this->_config['allowed_methods'])) {
            $status = 200;  // ok
        } else {
            $status = 405;  // request method not allowed
        }

        return $status;
    }

}