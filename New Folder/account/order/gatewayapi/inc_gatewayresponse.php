<?php

	$GLOBALS['_transient']['static']['GatewayResponse']->FieldNames = array (
		"ResponseCode"				=> 1,
		"ResponseSubcode"			=> 2,
		"ResponseReasonCode"		=> 3,
		"ResponseReasonText"		=> 4,
		"ApprovalCode"				=> 5,
		"AVSResultCode"				=> 6,
		"TransactionId"				=> 7,
		"InvoiceNumber"				=> 8,
		"Description"				=> 9,
		"Amount"					=> 10,
		"Method"					=> 11,
		"TransactionType"			=> 12,
		"CustomerId"				=> 13,
		"BillingFirstName"			=> 14,
		"BillingLastName"			=> 15,
		"BillingCompany"			=> 16,
		"BillingAddress"			=> 17,
		"BillingCity"				=> 18,
		"BillingState"				=> 19,
		"BillingZip"				=> 20,
		"BillingCountry"			=> 21,
		"BillingPhone"				=> 22,
		"BillingFax"				=> 23,
		"BillingEmail"				=> 24,
		"ShippingFirstName"			=> 25,
		"ShippingLastName"			=> 26,
		"ShippingCompany"			=> 27,
		"ShippingAddress"			=> 28,
		"ShippingCity"				=> 29,
		"ShippingState"				=> 30,
		"ShippingZip"				=> 31,
		"ShippingCountry"			=> 32,
		"TaxAmount"					=> 33,
		"DutyAmount"				=> 34,
		"FreightAmount"				=> 35,
		"TaxExemptOption"			=> 36,
		"PurchaseOrderNumber"		=> 37,
		"MD5Hash"					=> 38,
		"CVVResponseCode"			=> 39,
		"CAVVResponseCode"			=> 40,
	);


	class GatewayResponse
	{
		var $response_string;
		var $response_array;
		
		var $response_code;
		var $response_text;
		var $transaction_id;
		
		var $FieldNames;
		
		function GatewayResponse($responseString, $delimiter)
		{
			$this->FieldNames = & $GLOBALS['_transient']['static']['GatewayResponse']->FieldNames;			
			
			$this->response_string = $responseString;
			
			$this->response_array = explode($delimiter, $this->response_string);
		}
		
		function GetField($index)
		{
			if(is_numeric($index))
				$i = $index;
			else
				$i = $this->FieldNames[$index];
				
			$i--;
			

			if(($i === "") || ($i < 0) || ($i > count($this->FieldNames)))
				return("");
			
			return($this->response_array[$i]);
		}
		
		function IsApproved()
		{
			return($this->GetField("ResponseCode") == "1");
		}
		
		function IsDenied()
		{
			return($this->GetField("ResponseCode") == "2");
		}
		
		function IsError()
		{
			return($this->GetField("ResponseCode") == "3");
		}
		
		function GetAVSResultString()
		{
			$avsCode = $this->GetField("AVSResultCode");
			
			switch($avsCode)
			{
				case "A":
					return("Address (Street) matches, ZIP does not.");
				case "B":
					return("Address information not provided for Address Verification Service.");
				case "E":
					return("Address Verification error.");
				case "G":
					return("Non-U.S. Card Issuing Bank.");
				case "N":
					return("No Match on Address (Street) or ZIP.");
				case "P":
					return("Address Verification not applicable for this transaction.");
				case "R":
					return("Retry - System was unavailable or timed out.");
				case "S":
					return("Address Verification Service not supported by card issuer.");
				case "U":
					return("Address information is not available.");
				case "W":
					return("9 digit ZIP matches, Address (Street) does not.");
				case "X":
					return("Address (Street) and 9 digit ZIP match.");
				case "Y":
					return("Address (Street) and 5 digit ZIP match.");
				case "Z":
					return("5 digit ZIP matches, Address (Street) does not.");
				default:
					return("No Address Verification Response.");
			}
		}
		
		function GetCVVResultString()
		{
			$cvvCode = $this->GetField("CVVResponseCode");
			
			switch($cvvCode)
			{
				case "M":
					return("Match.");
				case "N":
					return("No Match.");
				case "P":
					return("Not Processed");
				case "S":
					return("Should have been on card, but wasn't sent.");	
				case "U":
					return("Card Bank unable to perform Card Code check.");
				default:
					return("No Card Code Verification Response.");
			}
		}
		
		function GetCAVVResultString()
		{
			$cavvCode = $this->GetField("CAVVResponseCode");
			
			switch($cavvCode)
			{
				case "0":
					return("Invalid Cardholder Authentication Verification data was submitted.");					
				case "1":
				case "7":
				case "9":
					return("Cardholder Authentication Verification failed.");
				case "2":
				case "A":
				case "8":
					return("Cardholder Authentication Verification succeeded.");
				case "3":
				case "4":
					return("Cardholder Authentication Verification could not be run because of a problem at the bank that issued this credit card.");
				case "5":
				case "6":
					return(""); // Reserved for future use.
				case "B":
					return("Cardholder Authentication Verification succeeded, but with 'information only'. There was no liability shift for the merchant.");
				default:
					return("No Cardholder Authentication Verification Response");					
			}
		}
		
		function VerifyMD5Hash($hashKey, $username, $amount)
		{
			$formattedAmount = StripNonMoney($amount);
			$formattedAmount = number_format($formattedAmount, 2, '.', '');
		
			$encryptedString = $hashKey . $username 
										. $this->GetField("TransactionId")
										. $formattedAmount;
										
//			print "COMPARING: " . $this->GetField("MD5Hash") . " to " . $encryptedString . " to " . md5($encryptedString) . "<BR>";
										
			return(strtoupper(md5($encryptedString)) == strtoupper($this->GetField("MD5Hash")));
		}
	}
		
?>