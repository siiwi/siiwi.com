<?php
/*  � 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = false;   // toggle to true if going against production
    $compatabilityLevel = 825;    // eBay API version
    
    if ($production) {
        $devID = '79f48070-280b-4fe6-9cf5-ab81ff816fa3';   // these prod keys are different from sandbox keys
        $appID = 'sparkzho-8de2-4ca3-94fa-acf8da020fd4';
        $certID = 'a8660576-c1c6-41a8-8764-68b55c446186';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'YOUR_PROD_TOKEN'; 
        $paypalEmailAddress= 'PRODUCTION_PAYPAL_EMAIL_ADDRESS';		
    } else {  
        $devID = 'DDD_SANDBOX';         // insert your devID for sandbox
        $appID = 'AAA_SANDBOX';   // different from prod keys
        $certID = 'CCC_SANDBOX';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'YOUR_TOKEN_ABOUT_1000_CHARS'; 
		$paypalEmailAddress = 'SANDBOX_PAYPAL_EMAIL_ADDRESS';		
    }
    
    
?>