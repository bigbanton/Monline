<?php
	include_once("inc_gatewayfunctions.php");

	// The scary looking words here just make it so we don't have to redefine these strings for
	// every GatewayTransaction instance.
	// Edit these error strings as you see fit.

	$GLOBALS['_transient']['static']['GatewayTransaction']->ErrorStrings = array (
			"MISSING_LOGIN"     	=>      "The Gateway login information for this store is not configured properly.",
			"MISSING_AMOUNT"    	=>      "This transaction requires an amount field.",
			"MISSING_CCNUMBER"		=>		"This transaction requires a credit card number.",
			"MISSING_EXPDATE"		=>		"This transaction requires a credit card expiration date.", 
			"MISSING_ROUTINGNUM"	=>		"This transaction requires a checking account routing number.",
			"MISSING_ACCOUNTNUM"	=>		"This transaction requires a checking account number.",
			"MISSING_TRANSACTIONID"	=>		"This transaction requires a Transaction Id to reference.",
			"MISSING_CURL"			=>		"The socket library for this store is missing or is not configured properly.",
			"MISSING_URL"			=>		"The Gateway url for this store is not configured properly.",
			"MISSING_DATA"			=>		"There seems to be a problem, no data was received for authorization. You have not been charged anything. Please try again or contact support for help.",
			"INVALID_CCNUMBER"  	=>      "The credit card number entered is not valid.",
			"INVALID_EXPDATE"		=>		"The credit card expiration date entered is not valid.",
			"INVALID_ROUTINGNUM"	=>		"The checking account routing number entered is not valid.",
			"INVALID_AMEXCVV"		=>		"The security code for American Express cards is found on the front of the card on the right side, and should be 4 digits.",
			"INVALID_CVV"			=>		"The security code for your credit card should be found in the signature area on the back of the card, and should be 3 digits.",
			"INVALID_MD5HASH"		=>		"The MD5 Authentication string returned by the Payment Gateway does not match what is configured for this store.",
			"INVALID_TYPE"			=> 		"This payment library does not recognize the type of transaction you are attempting. Please contact support for help.",
			"INVALID_METHOD"		=>		"This payment library does not recognize the method of payment you are attempting. Please contact support for help.",
			"UNACCEPTED_CARD"   	=>      "We're sorry, we cannot accept this type of card. Please use a different one.",
			"UNACCEPTED_ECHECKS"	=>		"We're sorry, we cannot currently accept electronic checks as payment. Please select a different payment option.",
			"AMOUNT_TOOLOW"    		=>      "We're sorry, we cannot accept transactions less than $1.00.",
			"AMOUNT_TOOHIGH"    	=>      "We're sorry, we cannot accept transactions of $100,000 or more. Please split up your payments, or contact support for help.",
			"EXPIRED_EXPDATE"    	=>     	"We're sorry,  this credit card has expired. Please use a different card or change the expiration date if you have received an updated card.",
			);

	$GLOBALS['_transient']['static']['GatewayTransaction']->GatewayFieldNames = array (
		/*	(Gateway Field Name,		Max Length,		Pre-Processing Callback Function, 	Field name to send to GatewayTransaction Class) */
		array ("x_login",						20,		NULL,					"username"),
		array ("x_tran_key",					20,		NULL,					"tran_key"),
		array ("x_type",						18,		NULL,					"type"),	
		array ("x_version",						3,		NULL,					"version"),
		array ("x_first_name",					50,		NULL,					"first_name"),
		array ("x_last_name",					50,		NULL,					"last_name"),
		array ("x_address",						60,		NULL,					"address"),
		array ("x_city",						40,		NULL,					"city"),
		array ("x_state",						40,		NULL,					"state"),
		array ("x_zip",							20,		NULL,					"zip"),
		array ("x_country",						60,		NULL,					"country"),
		array ("x_phone",						25,		NULL,					"phone"),
		array ("x_customer_ip",					15,		NULL,					"customer_ip"),
		array ("x_invoice_num",					20,		NULL,					"invoice_num"),
		array ("x_description",					248,	NULL,					"description"),
		array ("x_ship_to_first_name",			50,		NULL,					"shipping_first_name"),
		array ("x_ship_to_last_name",			50,		NULL,					"shipping_last_name"),
		array ("x_ship_to_company",				50,		NULL,					"shipping_company"),
		array ("x_ship_to_address",				60,		NULL,					"shipping_address"),
		array ("x_ship_to_city",				40,		NULL,					"shipping_city"),
		array ("x_ship_to_state",				40,		NULL,					"shipping_state"),
		array ("x_ship_to_zip",					20,		NULL,					"shipping_zip"),
		array ("x_ship_to_country",				60,		NULL,					"shipping_country"),
		array ("x_amount",						15,		"StripNonMoney",		"amount"),
//		array ("x_currency_code",				3,		NULL,					"currency_code"),
		array ("x_method",						6,		NULL,					"method"),
		array ("x_card_num",					22,		"StripNonNumeric",		"card_num"),
		array ("x_exp_date",					10,		"StripNonNumeric",		"exp_date"),
		array ("x_card_code",					4,		"StripNonNumeric",		"card_code"),
		array ("x_out_trade",        100,  NULL,  "out_trade"),
	);
				
				
	class GatewayTransaction
	{
		// API settings;
		var $type;
		var $method;
		var $version;
		var $username;
		var $tran_key;
		var $password;
		var $test_mode;		// TRUE/FALSE
		
		// Email Settings
		var $email_customer;
		var $merchant_email;
		var $header_email_receipt;
		var $footer_email_receipt;
		
		// Customer Information
		var $first_name;
		var $last_name;
		var $phone;
		var $fax;
		var $address;
		var $city;
		var $state;
		var $zip;
		var $country;
		var $company;
		var $email;
		var $customer_ip;
		var $customer_id;
	
		// Shipping Information
		var $shipping_company;
		var $shipping_first_name;
		var $shipping_last_name;
		var $shipping_address;
		var $shipping_city;
		var $shipping_state;
		var $shipping_zip;
		var $shipping_country;
			
		// Transaction Information
		var $amount;
		var $exp_month;
		var $exp_year;
		var $exp_date;
		var $card_code;
		var $card_num;
		var $description;
		var $tran_id;					// Gateway Transaction to reference for credit, void or prior_auth_capture
		var $purchase_order_num;		// Your own reference number - supposed to be the one given to customers
		var $invoice_num;				// Your own reference number
		var $tax;						// rarely used - tax is added into the $amount field	
		var $tax_exempt;				// rarely used - TRUE/FALSE
		var $freight;					// rarely used
		var $duty;						// rarely used
		var $recurring_billing;			// rarely used - TRUE/FALSE
		var $currency_code;				// rarely used - 3-letter currency like "USD" for US Dollars

	
		// E-Check Information
		var $check_type;
		var $check_acct_name;
		var $check_bank_name;
		var $check_acct_type;
		var $check_acct_num;
		var $check_aba_code;
	
		// Extra stuff - you most likely should not send these
		var $organization_type;
		var $license_state;
		var $license_num;
		var $license_dob;
		var $out_trade; 	
		
		// The API sets these so it can interpret the results
		var $delim_data;
		var $delim_char;
		var $encap_char;
		var $relay_response;
		
		var $ErrorStrings;
		var $GatewayFieldNames;
	
		function GatewayTransaction($variables, $ipaddress)
		{
			global $GatewaySettings;
			
			$this->ErrorStrings = & $GLOBALS['_transient']['static']['GatewayTransaction']->ErrorStrings;		
			$this->GatewayFieldNames = & $GLOBALS['_transient']['static']['GatewayTransaction']->GatewayFieldNames;					
			
			// Gateway options
			$this->method = "CC";   
			if($variables['method'])
				$this->method = $variables['method'];
				
			$this->type = "AUTH_CAPTURE"; 		
			if($variables['type'])
				$this->type = $variables['type'];
		
		
			// API Settings
			$this->username		= $GatewaySettings['username'];
			$this->tran_key		= $GatewaySettings['tran_key'];
			if($variables['password'])
				$this->password = $variables['password'];
			$this->version		= $GatewaySettings['version'];
//			$this->test_mode	= $GatewaySettings['test_mode'];
//			if($variables['test_mode'] && $GatewaySettings['AllowTestOverride'] == true)
//				$this->test_mode = $variables['test_mode'];
			
			
			// Email Settings
			$this->email_customer 	= $GatewaySettings['email_customer'];
			if($variables['email_customer'])
				$this->email_customer = $variables['email_customer'];
			
			$this->merchant_email	= $GatewaySettings['merchant_email'];
			if($variables['merchant_email'])
				$this->merchant_email = $variables['merchant_email'];
			
			$this->header_email_receipt = $GatewaySettings['header_email_receipt'];
			if($variables['header_email_receipt'])
				$this->header_email_receipt = $variables['header_email_receipt'];
				
			$this->footer_email_receipt = $GatewaySettings['footer_email_receipt'];
			if($variables['footer_email_receipt'])
				$this->footer_email_receipt = $variables['footer_email_receipt'];
			
			
			// Contact Information
			$this->first_name	= $variables['first_name']; 
			$this->last_name	= $variables['last_name'];
			$this->phone		= $variables['phone'];
			$this->fax			= $variables['fax'];
			$this->address		= $variables['address'];
			$this->city			= $variables['city']; 
			$this->state		= $variables['state'];
			$this->zip			= $variables['zip'];
			$this->country		= $variables['country'];
			$this->company		= $variables['company'];
			$this->email		= $variables['email'];
			$this->customer_ip	= $ipaddress;
			$this->out_trade = $variables['out_trade'];
			
			
			// Transaction Information 
			$this->card_num				= StripNonNumeric($variables['card_num']);
			$this->exp_month			= StripNonNumeric($variables['exp_month']);
			$this->exp_year 			= StripNonNumeric($variables['exp_year']);
			$this->card_code			= StripNonNumeric($variables['card_code']);
			$this->amount				= StripNonMoney($variables['amount']);
			$this->customer_id			= $variables['customer_id']; // For your reference; not used by authnet.
			$this->invoice_num			= $variables['invoice_num'];
			$this->description			= $variables['description'];
			$this->tran_id				= StripNonNumeric($variables['tran_id']);
			$this->recurring_billing 	= $variables['recurring_billing'];
			$this->currency_code		= $variables['currency_code'];
			
			
			// Shipping Information 
			$this->shipping_company 	= $variables['shipping_company'];
			$this->shipping_first_name 	= $variables['shipping_first_name'];
			$this->shipping_last_name	= $variables['shipping_last_name'];
			$this->shipping_address 	= $variables['shipping_address'];
			$this->shipping_city 		= $variables['shipping_city'];
			$this->shipping_state 		= $variables['shipping_state'];
			$this->shipping_zip 		= $variables['shipping_zip'];
			$this->shipping_country		= $variables['shipping_country']; 
			
			
			// E-Check Information 
			$this->check_aba_code	= StripNonNumeric($variables['check_aba_code']);  	// Customer Routing Number
			$this->check_acct_num	= StripNonNumeric($variables['check_acct_num']);  	// Customer Account Number
			$this->check_acct_type	= $variables['check_acct_type']; 	// Customer Account Type ("CHECKING" or "SAVINGS")
			$this->check_bank_name	= $variables['check_bank_name'];  	// Customer Bank Name
			$this->check_acct_name	= $variables['check_acct_name']; 	// Customer Bank Account Owner
			$this->check_type		= $variables['check_type'];   		// Must be "WEB", if anything.
			
			
			// Optional Extra Data - rarely used
			$this->purchase_order_num	= $variables['purchase_order_num']; 
			$this->tax_exempt			= $variables['tax_exempt'];
			
			// The dollar amounts below must already be included in the 'amount' field. You would only 
			// put them here if you wanted the transaction to specifically note the different dollar amounts 
			// or if you were required to do so by your processor.
			// These are rarely used and generally unnecessary.
			$this->tax				= $variables['tax'];
			$this->freight			= $variables['freight'];
			$this->duty				= $variables['duty'];		
			
			// Shouldn't be used unless directed to
			$this->organization_type	= $variables['organization_type'];
			$this->license_state		= $variables['license_state'];
			$this->license_num			= $variables['license_num'];
			$this->license_dob			= $variables['license_dob'];
			$this->customer_ssn			= $variables['customer_ssn']; 				
		}
			
			
		function VerifyFields(&$errorCode)
		{
			global $GatewaySettings;
				
			// Check for required settings
			if(!$this->username || (!$this->tran_key && !$this->password))
			{
				$errorCode = "MISSING_LOGIN";
				return(false);
			}	
				
			// Check for required Transaction data
			if($this->type == "AUTH_CAPTURE" 
				|| $this->type == "AUTH_ONLY"
				|| $this->type == "CREDIT")
			{
				// Check for an amount
				if(!VerifyAmount($this->amount, $errorCode))
					return(false);
				
				// Check for a payment method
				if($this->type != "CREDIT")
				{
					if($this->method == "CC")
					{
						if(!VerifyCCNumber($this->card_num, $errorCode))
							return(false);
							
						if(!VerifyExpirationDate($this->exp_month, $this->exp_year, $errorCode))
							return(false);
						else
							$this->exp_date = $this->exp_month . $this->exp_year;
							
						if($this->card_code)
							if(!VerifyCVVCode($this->card_code, $this->card_num, $errorCode))
								return(false);
					}
					else if($this->method == "ECHECK")
					{
						if(!$GatewaySettings['AllowEChecks'])
						{
							$error = "UNACCEPTED_ECHECKS";
							return(false);
						}
						
						if(!VerifyRoutingNumber($this->check_aba_code, $error))
							return(false);
							
						if(!VerifyCheckingAccountNumber($this->check_acct_num, $error))
							return(false);
					}
					else
					{
						$error = "INVALID_METHOD";
						return(false);
					}
				}
				else
				{
					if(!$this->tran_id)
					{
						$error = "MISSING_TRANSACTIONID";
						return(false);
					}
				}
			}
			else if($this->type == "VOID"
					|| $this->type == "PRIOR_AUTH_CAPTURE")
			{
					if(!$this->tran_id)
					{
						$error = "MISSING_TRANSACTIONID";
						return(false);
					}				
			}
			else
			{
				$error = "INVALID_TYPE";
				return(false);
			}
			
			return(true);
		}		
			
			
		function CreatePostString()
		{
			global $GatewaySettings;
			
			$postString = "";
			
			$numFields = count($this->GatewayFieldNames);
			for($iField = 0; $iField < $numFields; $iField++)
			{
				list($gField, $maxLength, $callback, $classField) = $this->GatewayFieldNames[$iField];
				
				// Run special formatting functions
				if($callback)
					$value = $callback($this->$classField);
				else
					$value = $this->$classField;
					
				if($value !== "")
				{	
					// Truncate to maximum length for field
					$value = substr($value, 0, $maxLength);
					
					// Append value to request
					$postString .= "$gField=" . urlencode($value) . "&";
					$poststring = rtrim( $poststring, "& " );
				}
			}
			return($postString);
		}
		
		
		function ProcessTransaction()
		{
			global $GatewaySettings;
			
			if(!$this->VerifyFields($errorCode))
			return array(false,$response,$errorCode);
				
			$postString = $this->CreatePostString() . "x_relay_response=FALSE&x_delim_data=TRUE";
    // print $postString;

			$request = curl_init($GatewaySettings['url']); // initiate curl object
      curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
      curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
      curl_setopt($request, CURLOPT_POSTFIELDS, $postString); // use HTTP POST to send form data
      curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
      curl_setopt($request, CURLOPT_POST, 1); // uncomment this line if you get no gateway response.
      $response = curl_exec($request); // execute curl post and store results in $post_response
	// additional options may be required depending upon your server configuration
	// you can find documentation on curl options at http://www.php.net/curl_setopt
    curl_close ($request); // close curl object
    
//    print $response;

			return array(true,$response,$errorCode);
		}
		
		
		function GetErrorString($errorCode)
		{
			return($this->ErrorStrings[$errorCode]);
		}
	};

?>