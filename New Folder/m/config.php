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

define('STANDARD_SITE', $_SERVER["SERVER_NAME"]);

define('MOBILE_SITE', $INI['system']['mlocation']);

define('DEFAULT_AVATAR', 'defaultAvatar.jpg');

define('DEFAULT_TIME_FORMAT', 'H:i a M jS');

// records per page general
define('RECORDS_PER_PAGE', 5);

// records per page for replies page
define('RECORDS_PER_PAGE_REPLIES', 5);

// records per page for friends page
define('RECORDS_PER_PAGE_FRIENDS', 5);

// some configurations from standard website
define("CONTACT_MAIL", $INI['system']['cpemail']);

?>