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

include(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');

$amm = $_POST['x_charamm'];

$charfor = $_POST['x_charity'];

function updateDonation($charfor, $amm)

{
    
    
    
    if ($charfor == 'PCharity')
    
     {
        
        // $pcharity = $pcharity + $amm;
        $filename = "pcharitycount.txt"; // This is at root of the file using this script.
        
        
         $fd = fopen ($filename, "r"); // opening the file counter.txt in read mode
        
        
         $contents = fread ($fd, filesize($filename)); // reading the content of the file
        
        
         fclose ($fd); // Closing the file pointer
        
        
         $contents = $contents + $amm; // incrementing the counter value by one
        
        
         echo $contents; // printing the incremented counter value
        
        
        
        
         $fp = fopen ($filename, "w"); // Open the file in write mode
        
        
         fwrite ($fp, $contents); // Write the new data to the file
        
        
         fclose ($fp); // Closing the file pointer 
        
        
        
        
        } 
    
    
    
    if ($charfor == 'OCharity')
    
     {
        
        // $ocharity = $ocharity + $amm;
        $filename = "ocharitycount.txt"; // This is at root of the file using this script.
        
        
         $fd = fopen ($filename, "r"); // opening the file counter.txt in read mode
        
        
         $contents = fread ($fd, filesize($filename)); // reading the content of the file
        
        
         fclose ($fd); // Closing the file pointer
        
        
         $contents = $contents + $amm; // incrementing the counter value by one
        
        
         echo $contents; // printing the incremented counter value
        
        
        
        
         $fp = fopen ($filename, "w"); // Open the file in write mode
        
        
         fwrite ($fp, $contents); // Write the new data to the file
        
        
         fclose ($fp); // Closing the file pointer 
        
        
        } 
    
    
    
    if ($charfor == 'CCharity')
    
     {
        
        // $ccharity = $ccharity + $amm;
        $filename = "ccharitycount.txt"; // This is at root of the file using this script.
        
        
         $fd = fopen ($filename, "r"); // opening the file counter.txt in read mode
        
        
         $contents = fread ($fd, filesize($filename)); // reading the content of the file
        
        
         fclose ($fd); // Closing the file pointer
        
        
         $contents = $contents + $amm; // incrementing the counter value by one
        
        
         echo $contents; // printing the incremented counter value
        
        
        
        
         $fp = fopen ($filename, "w"); // Open the file in write mode
        
        
         fwrite ($fp, $contents); // Write the new data to the file
        
        
         fclose ($fp); // Closing the file pointer 
        
        
        } 
    
    
    
    } 

// include('Count.php');
updateDonation($charfor, $amm);

/**
 * //$c=new Count();
 * 
 * 
 * 
 * if($charfor=='PCharity')
 * 
 * {
 * 
 * //$c-->donatePCharity($amm);
 * 
 * $pcharity = $pcharity + $amm;
 * 
 * echo "The charity is: $pcharity";
 * 
 * }
 * 
 * 
 * 
 * if($charfor=='OCharity')
 * 
 * {
 * 
 * $c-->donateOCharity($amm);
 * 
 * }
 * 
 * 
 * 
 * if($charfor=='CCharity')
 * 
 * {
 * 
 * $c-->donateCCharity($amm);
 * 
 * }
 */

$a = new authorizenet();

 $a->add_field('x_login', 'CHANGE THIS TO YOUR LOGIN');

 $a->add_field('x_tran_key', 'CHANGE THIS TO YOUR TRANSACTION KEY');

 $a->add_field('x_version', '3.1');

 $a->add_field('x_type', 'AUTH_CAPTURE');

 $a->add_field('x_relay_response', 'FALSE');

 $a->add_field('x_encap_char', '');

 $a->add_field('x_item_name', $charfor);

 $a->add_field('x_item_number', '100');

 $a->add_field('x_currency_code', $mydef_currency);

 $a->add_field('x_amount', $amm);

switch ($a->process()) {

case 1: // Successs
    echo "<b>Success:</b><br>";
    
     echo $a->get_response_reason_text();
    
     echo "<br><br>Details of the transaction are shown below...<br><br>";
    
     break;

 case 2: // Declined
    echo "<b>Payment Declined:</b><br>";
    
     echo $a->get_response_reason_text();
    
     echo "<br><br>Details of the transaction are shown below...<br><br>";
    
     break;

 case 3: // Error
    echo "<b>Error with Transaction:</b><br>";
    
     echo $a->get_response_reason_text();
    
     echo "<br><br>Details of the transaction are shown below...<br><br>";
    
     break;
    
    } 

// The following two functions are for debugging and learning the behavior
// of authorize.net's response codes.  They output nice tables containing
// the data passed to and recieved from the gateway.

$a->dump_fields(); // outputs all the fields that we set

$a->dump_response();

/**
 * class Count{
 * 
 * 
 * 
 * function donatePCharity($amm)
 * 
 * {
 * 
 * /*	echo ("Old pcharity:$pcharity");
 * 
 * $pcharity=$pcharity+$amm;
 * 
 * echo ("New pcharity:$pcharity");
 * 
 * $GLOBALS['pcharity'] = $GLOBALS['pcharity'] + $GLOBALS['amm'];
 * 
 * }
 * 
 * 
 * 
 * function donateOCharity($amm)
 * 
 * {
 * 
 * $GLOBALS['ocharity'] = $GLOBALS['ocharity'] + $GLOBALS['amm'];
 * 
 * //$ocharity=$ocharity+$amm;
 * 
 * }
 * 
 * 
 * 
 * function donateCCharity($amm)
 * 
 * {
 * 
 * $GLOBALS['ccharity'] = $GLOBALS['ccharity'] + $GLOBALS['amm'];
 * 
 * //$ccharity=$ccharity+$amm;
 * 
 * }
 * 
 * 
 * 
 * function getPCharity()
 * 
 * {
 * 
 * return $GLOBALS['pcharity'];
 * 
 * }
 * 
 * 
 * 
 * function getOCharity()
 * 
 * {
 * 
 * return $GLOBALS['ocharity'];
 * 
 * }
 * 
 * 
 * 
 * function getCCharity()
 * 
 * {
 * 
 * return $GLOBALS['ccharity'];
 * 
 * }
 * 
 * }
 */

class authorizenet {

var $field_string;

 var $fields = array();

 var $response_string;

 var $response = array();

 var $gateway_url = "https://secure.authorize.net/gateway/transact.dll";

 function authorizenet()
{

 // some default values

$this->add_field('x_version', '3.1');

 $this->add_field('x_delim_data', 'TRUE');

 $this->add_field('x_delim_char', '|');

 $this->add_field('x_url', 'FALSE');

 $this->add_field('x_type', 'AUTH_ONLY');

 $this->add_field('x_method', 'CC');

 $this->add_field('x_relay_response', 'FALSE');

 } 

function add_field($field, $value)
{

 // adds a field/value pair to the list of fields which is going to be
// passed to authorize.net.  For example: "x_version=3.1" would be one
// field/value pair.  A list of the required and optional fields to pass
// to the authorize.net payment gateway are listed in the AIM document
// available in PDF form from www.authorize.net

$this->fields["$field"] = $value;

 } 

function process()
{

 // This function actually processes the payment.  This function will
// load the $response array with all the returned information.  The return
// values for the function are:
// 1 - Approved
// 2 - Declined
// 3 - Error

// construct the fields string to pass to authorize.net
foreach($this->fields as $key => $value)

 $this->field_string .= "$key=" . urlencode($value) . "&";

 // execute the HTTPS post via CURL
$ch = curl_init($this->gateway_url);

 curl_setopt($ch, CURLOPT_HEADER, 0);

 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

 curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($this->field_string, "& "));

 $this->response_string = urldecode(curl_exec($ch));

 if (curl_errno($ch)) {
    
    $this->response['Response Reason Text'] = curl_error($ch);
    
     return 3;
    
     } 

else curl_close ($ch);

 // load a temporary array with the values returned from authorize.net
$temp_values = explode('|', $this->response_string);

 // load a temporary array with the keys corresponding to the values
// returned from authorize.net (taken from AIM documentation)
$temp_keys = array (
    
    "Response Code", "Response Subcode", "Response Reason Code", "Response Reason Text",
    
     "Approval Code", "AVS Result Code", "Transaction ID", "Invoice Number", "Description",
    
     "Amount", "Method", "Transaction Type", "Customer ID", "Cardholder First Name",
    
     "Cardholder Last Name", "Company", "Billing Address", "City", "State",
    
     "Zip", "Country", "Phone", "Fax", "Email", "Ship to First Name", "Ship to Last Name",
    
     "Ship to Company", "Ship to Address", "Ship to City", "Ship to State",
    
     "Ship to Zip", "Ship to Country", "Tax Amount", "Duty Amount", "Freight Amount",
    
     "Tax Exempt Flag", "PO Number", "MD5 Hash", "Card Code (CVV2/CVC2/CID) Response Code",
    
     "Cardholder Authentication Verification Value (CAVV) Response Code"
    
    );

 // add additional keys for reserved fields and merchant defined fields
for ($i = 0; $i <= 27; $i++) {
    
    array_push($temp_keys, 'Reserved Field ' . $i);
    
     } 

$i = 0;

 while (sizeof($temp_keys) < sizeof($temp_values)) {
    
    array_push($temp_keys, 'Merchant Defined Field ' . $i);
    
     $i++;
    
     } 

// combine the keys and values arrays into the $response array.  This
// can be done with the array_combine() function instead if you are using
// php 5.
for ($i = 0; $i < sizeof($temp_values);$i++) {
    
    $this->response["$temp_keys[$i]"] = $temp_values[$i];
    
     } 

// $this->dump_response();
// Return the response code.
return $this->response['Response Code'];

 } 

function get_response_reason_text()
{

 return $this->response['Response Reason Text'];

 } 

function dump_fields()
{

 // Used for debugging, this function will output all the field/value pairs
// that are currently defined in the instance of the class using the
// add_field() function.

echo "<h3>authorizenet_class->dump_fields() Output:</h3>";

 echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">

            <tr>

               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>

               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>

            </tr>";

 foreach ($this->fields as $key => $value) {
    
    echo "<tr><td>$key</td><td>" . urldecode($value) . "&nbsp;</td></tr>";
    
     } 

echo "</table><br>";

 } 

function dump_response()
{

 // Used for debuggin, this function will output all the response field
// names and the values returned for the payment submission.  This should
// be called AFTER the process() function has been called to view details
// about authorize.net's response.

echo "<h3>authorizenet_class->dump_response() Output:</h3>";

 echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">

            <tr>

               <td bgcolor=\"black\"><b><font color=\"white\">Index&nbsp;</font></b></td>

               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>

               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>

            </tr>";

 $i = 0;

 foreach ($this->response as $key => $value) {
    
    echo "<tr>

                  <td valign=\"top\" align=\"center\">$i</td>

                  <td valign=\"top\">$key</td>

                  <td valign=\"top\">$value&nbsp;</td>

               </tr>";
    
     $i++;
    
     } 

echo "</table><br>";

 } 

} 

?>