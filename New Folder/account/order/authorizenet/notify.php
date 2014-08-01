<?php

/**
 * //License information must not be removed.
 * 
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @Architecture ### Secured  ###
 * @Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @License EULA License http://www.gripsell.com
 * @Author $Author: gripsell $
 * @Version $Version: 5.3.3 $
 * @Last Revision $Date: 2013-21-05 00:00:00 +0530 (Tue, 21 May 2013) $
 */
// Include the paypal library
include_once ('Authorize.php');

// Create an instance of the authorize.net library
$myAuthorize = new Authorize();

// Log the IPN results
$myAuthorize->ipnLog = true;

// Specify your authorize login and secret
$myAuthorize->setUserInfo('YOUR_LOGIN', 'YOUR_SECRET_KEY');

// Check validity and write down it
if ($myAuthorize->validateIpn())
     {
    file_put_contents('authorize.txt', 'SUCCESS');
    } 
else
     {
    file_put_contents('authorize.txt', "FAILURE\n\n" . $myAuthorize->ipnData);
    } 
