<?php



/**



 * //License information must not be removed.



 * PHP version 5.2x



 *



 * @category	### Gripsell ###



 * @package		### Advanced ###



 * @arch		### Secured  ###



 * @author 		Development Team, Gripsell Tech



 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}



 * @license		http://www.gripsell.com Clone Portal



 * @version		4.3.0



 * @since 		2011-03-15



 */



//



// YOU MUST READ THE ATTACHED NOTES CAREFULLY BEFORE EDITING ANY VARIABLE IN THIS FILE.







// MAKE SURE THAT THE LOCATION OF THIS FILE IS ALWAYS THE ROOT OF YOUR WEB URL



// EXAMPLE http://www.yourdomain.com/config.php OR http://subdomain.yourdomain.com/config.php



// depending upon where you installed the package. Do not put this file into the folder.







// All edits are at your risk only. The Clone Portal or any associated business is not liable for any change here.







//#######################################       CONFIGURABLE OPTIONS START HERE    ############################################







//########### YOUR DOMAIN/SUB-DOMAIN NAME WHERE THIS SCRIPT IS INSTALLED ############



$domain = 'http://domain.com/';



//Exact domain name or sub-domain name where Gripsell



//script is installed. NO FOLDERS.











//########### FOLDER NAME IN WHICH THE SCRIPT IS INSTALLED, READ TEXT BELOW ############



//If you are installing Gripsell Script in a folder (example, http://www.abc.com/deals)



//then mention the folder name, without trailing slash. In this case, it looks like:



//$iFolder = 'deals';



//If installation is on main domain or sub-domain, example http://www.abc.com/, then leave



//it blank.



$iFolder = '';











//########### ROOT PATH TO BACKEND FOLDER ############



//THIS FOLDER, SUB-FOLDERS AND FILES WITHIN IN MUST HAVE WRITE PERMISSION (CHMOD 777).



//DO NOT UPLOAD IT TO PUBLIC ACCESS FOLDER LIKE /public_html or /www, etc.



//NO TRAILING SLASHES.



define('DIR_BACKEND', '/home/demopro/backend');



//Replace PATH TO BACKEND FOLDER with actual patch to the backend folder



//example, do not use: '/home/cloneportal/backend'



//example of public folder: '/home/cloneportal/public_html'











//For hosting server that do not follow industry standards for folder structure



define('NS_STRUCTURE', FALSE);















//########### PRIMARY LANGUAGE ############



//SET THIS IF SELECTION OF LANGUAGE FROM THE ADMIN PANEL IS NOT WORKING.



$defaultlanguage = 'en';











//################### OPTIONAL:: Database Settings ###############



//If not sure, check with your hosting provider



$mydef_dbhost = 'localhost';

// Database Username

$mydef_dbuser = 'dbuser';

// Database Password

$mydef_dbpass = 'dbpassword';

// Name of the Database

$mydef_dbname = 'dbname';







//################## DEPRECATED :: Installation Folder ################



//Functionality deprecated for security reasons



$mydef_folder = '';



// Also referred to as BASE_FOLDER and INSTALLATION FOLDER 



// Leave blank if installing the programme in the root of the site



// example at http://www.yourdomain.com/



// or if installing at sub-domain



// example http://subdomain.yourdomain.com







// IMPORTANT:



// If your installation location looks like any of the following, then



// you must define the folder name WITHOUT leading or trailing slash '/'







// Example: http://www.yourdomain.com/mydeals/ 



// then define the folder as 'mydeals'







// Example: http://subdomain.yourdomain.com/thedeals



// then define the folder as 'thedeals'







// Example: http://www.yourdomain.com/folder1/deals



// or http://subdomain.yourdomain.com/folder1/deals



// then define the folder 'folder1/deals'







$error_reporting = 0;







//**************** Do not edit below this line **********************



	// Database host



    define('DATABASE_HOST', '<DB_HOST>');



    // Name of the database to be used



    define('DATABASE_NAME', '<DB_NAME>');



    // User name for access to database



    define('DATABASE_USERNAME', '<DB_USER>');



    // Password for access to database



    define('DATABASE_PASSWORD', '<DB_PASSWORD>');



    // Unique prefix of all tables in the database



    define('DB_PREFIX', '<DB_PREFIX>');



	// AES|MD5



    define("PASSWORDS_ENCRYPTION_TYPE",  "MD5");



    // true|false



    define("PASSWORDS_ENCRYPTION",  true);



    define("PASSWORDS_ENCRYPT_KEY", "cloneportalep");







//################### Currency ######################



// Edit only if payment gateway is unable to detect your currency.



// Use 3 letter currency code as accepted by the payment gateway.



$mydef_currency = $INI['system']['currcode'];











//################### Default Timezone################



$mydef_timezone = $INI['system']['timezone'];



//Check more PHP Time Zones at



// http://www.php.net/manual/en/timezones.america.php











//################# Charity Functionality ################



//1 = Enable and 0 = Disable



$showcharity = abs(intval($INI['charity']['showcharity']));



//Name of Charity Support



$charity1 = $INI['charity']['charopa'];



$charity2 = $INI['charity']['charopb'];



$charity3 = $INI['charity']['charopc'];







//############## Subscription Automation ################



// Works only when Subscription Module (add-on) is installed.



// Auto emails will be sent only for the deals created after turning on



// this option







$mydef_sendoption = abs(intval($INI['system']['dealalert']));



// 0 = Do not auto send



// 1 = Send every day



// 2 = Send when the deal is created



// Change your Cron job setting to change the send schedule







//Define this key only if you are asked to do so.



$mydef_currency = $mydef_currency  ? $mydef_currency : $currency;



$mydef_key = 'f8WE45Y^';