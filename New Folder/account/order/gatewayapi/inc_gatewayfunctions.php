<?php

	function StripNonNumeric($field)
	{
		return(preg_replace("/[^\d]/", "", $field));
	}

	function StripNonMoney($field)
	{
		return(preg_replace("/[^\d.]/", "", $field));
	}
	
	function TRUEorFALSE($field)
	{
		$s = strtoupper($field);
		
		if($s != "TRUE" && $s != "FALSE")
			$s = "";
			
		return($s);
	}
	
	 /**
	  * function that attempts to figure out the credit card type based off the card number
	 **/
	 
	$_EnumCreditCardTypes = array (
		"Visa"			=> 0,
		"Mastercard"	=> 1,
		"Discover"		=> 2,
		"Amex"			=> 3,
		"DinersClub"	=> 4,
		"CarteBlanche"	=> 5,
		"EnRoute"		=> 6,
		"JCB"				=> 7,
		"Unknown"		=> 8,		
	);

	function EnumCardTypes($type)
	{
		global $_EnumCreditCardTypes;
		
		if(isset($_EnumCreditCardTypes[$type]))
			return($_EnumCreditCardTypes[$type]);
		else
			return($_EnumCreditCardTypes["Unknown"]);
	}
	
	function GetCardType (&$cardnum) {
		 $cardnum = StripNonNumeric($cardnum);
		 $length = strlen($cardnum);
		 if ($length == 16 && substr($cardnum, 0, 2) >= 51 && substr($cardnum, 0, 2) <= 55)
				 return(EnumCardTypes("Mastercard"));
		 else if (($length == 16 || $length == 13) && substr($cardnum, 0, 1) == 4)
				 return(EnumCardTypes("Visa"));
		 else if ($length == 15 && (substr($cardnum, 0, 2) == 34 || substr($cardnum, 0, 2) == 37))
				 return(EnumCardTypes("Amex"));
		 else if ($length == 16 && substr($cardnum, 0, 4) == 6011)
				 return(EnumCardTypes("Discover"));
		 else if ($length == 14 && (substr($cardnum, 0, 2) == 36 || substr($cardnum, 0, 2) == 38 || (substr($cardnum, 0, 3) >= 300 || substr($cardnum, 0, 3) <= 305)))
				 return(EnumCardTypes("DinersClub"));
		 else if ($length == 16 && ($cardnum[0] == '3'))
				 return(EnumCardTypes("JCB"));
		 else if ($length == 15 && (substr($cardnum, 0, 4) == 1800 || substr($cardnum, 0, 4) == 2131))
				 return(EnumCardTypes("JCB")); 
		 else if ($length == 15 && (substr($cardnum, 0, 4) == 2014 || substr($cardnum, 0, 4) == 2149))
				 return(EnumCardTypes("EnRoute"));
		 else if ($length == 14 && ($cardnum[0] == '3' && $cardnum[1] == '8'))
				return(EnumCardTypes("CarteBlanche"));
		 else
				return(EnumCardTypes("Unknown"));
	}

	function CheckLuhn10 ($num) {
		$num = StripNonNumeric($num);
		$num = strrev($num);
		$total = 0;

		for ($x = 0; $x < strlen($num); $x++) {
			$digit = substr($num, $x, 1);
			if ($x / 2 != floor ($x / 2)) {
				$digit *= 2;
				if (strlen($digit) == 2 )
					$digit = substr($digit, 0 , 1) + substr($digit, 1 , 1);
			}
			$total += $digit;
		}

		return ($total % 10 == 0);
	}

	function CheckCardAcceptance($cardType)
	{
		global $GatewaySettings;

		switch($type)
		{
			case EnumCardTypes("Visa"):
				return($GatewaySettings['AllowVisa']);
			case EnumCardTypes("Mastercard"):
				return($GatewaySettings['AllowMC']);
			case EnumCardTypes("Discover"):
				return($GatewaySettings['AllowDiscover']);
			case EnumCardTypes("Amex"):
				return($GatewaySettings['AllowAmex']);
			case EnumCardTypes("DinersClub"):
				return($GatewaySettings['AllowDiners']);
			case EnumCardTypes("CarteBlanche"):
				return($GatewaySettings['AllowCarteBlanche']);
			case EnumCardTypes("EnRoute"):
				return($GatewaySettings['AllowEnRoute']);
			case EnumCardTypes("JCB"):
				return($GatewaySettings['AllowJCB']);
		};
		
		return(false);
	}

	function VerifyCCNumber(&$cardnum, &$error)
	{
		$error = "";		
		
		if($cardnum === "")
			$error = "MISSING_CCNUMBER";
		else
		{
			if(!CheckLuhn10($cardnum))
				$error = "INVALID_CCNUMBER";
			else
			{
				$type = GetCardType($cardnum);
				
				if($type == EnumCardTypes("Unknown"))
					$error = "UNACCEPTED_CARD";
				else		
					if(!CheckCardAcceptance($type))	
						$error = "UNACCEPTED_CARD";
			}
		}
		
		return($error == "");
	}
	
	function VerifyAmount(&$amount, &$error)
	{
		$error = "";
		
		$amount = StripNonMoney($amount);

		if($amount === "")
			$error = "MISSING_AMOUNT";
		
		if($amount < 1.0)
			$error = "AMOUNT_TOOLOW";
		else if($amount >= 100000.00)
			$error = "AMOUNT_TOOHIGH";

		return($error == "");
	}
	
	function CheckMonthIsNotPast($month, $year)
	{
		//
		// Make sure your computer's date/time are set!
		//
		$currentDate = localtime(time(), true);

		// php localtime returns the year as the number of years since 1900
		$currentYear = $currentDate['tm_year'] + 1900;
		
		// php localtime returns the month number starting at 0
		$currentMonth = $currentDate['tm_mon'] + 1;
		
		if(strlen($year) == 2)
			$testYear = 2000 + $year; // These dates are supposed to be in the future.
		else
			$testYear = $year;
			
		if($testYear < $currentYear)
			return(false);
		else if(($testYear == $currentYear) && ($month < $currentMonth))
			return(false);
		else
			return(true);
	}
	
	function VerifyExpirationDate(&$expMonth, &$expYear, &$error)
	{
		$error = "";
		
		$expMonth = StripNonNumeric($expMonth);
		$expYear = StripNonNumeric($expYear);
		
		if($expMonth === "" || $expYear === "") 
			$error = "MISSING_EXPDATE";
		else
		{
			$yearLength = strlen($expYear);
			if(($yearLength != 2 && $yearLength != 4) || ($expMonth > 12) || ($expMonth < 0))
				$error = "INVALID_EXPDATE";
			else if(!CheckMonthIsNotPast($expMonth, $expYear))
				$error = "EXPIRED_EXPDATE";
		}
			
		return($error == "");
	}
	
	function VerifyCVVCode(&$cvv, $cardnum, &$error)
	{
		$error = "";
		
		$cvv = StripNonNumeric($cvv);
		$type = GetCardType($cardnum);
		
		if($type == EnumCardTypes("Amex"))
		{
			if(strlen($cvv) != 4)
				$error = "INVALID_AMEXCVV";
		}
		else if(strlen($cvv) != 3)
			$error = "INVALID_CVV";
			
		return($error == "");
	}
	
	function CheckRoutingNumber($routingNum)
	{
		$routingNum = StripNonNumeric($routingNum);
		$length = strlen($routingNum);

		if($length != 9)
			return(false);

		$checkDigit = 0;
		for ($i = 0; $i < $length; $i += 3)
		{
			$checkDigit += $routingNum[$i] * 3
			  +  $routingNum[$i + 1] * 7
			  +  $routingNum[$i + 2];
		}
		
		// If the resulting sum is an even multiple of ten (but not zero),
		// the aba routing number is good.
		return (($checkDigit != 0) && (($checkDigit % 10) == 0));
	}	
	
	function VerifyRoutingNumber(&$routingNum, $error)
	{
		$error = "";
		
		$routingNum = StripNonNumeric($routingNum);
		
		if($routingNum === "")
			$error = "MISSING_ROUTINGNUM";
		else if(!CheckRoutingNumber($routingNum))
			$error = "INVALID_ROUTINGNUM";
			
		return($error == "");
	}
	
	function VerifyCheckingAccountNumber(&$accountNum, $error)
	{
		$error = "";
		
		$accountNum = StripNonNumeric($accountNum);
		
		if($accountNum === "")
			$error = "MISSING_ACCOUNTNUM";
		
		return($error == "");
	}
	
	function SendHTTPPostData($data, $url, &$response, &$error)
	{
		global $GatewaySettings;
		
		$error = "";
		
		if(!$url)
			$error = "MISSING_URL";
		else if(!$data)
			$error = "MISSING_DATA";
		else
		{
		
			if (!extension_loaded('curl')) 
			{
				if($GatewaySettings['curl_location'] && is_file($GatewaySettings['curl_location']))
				{
					$data = escapeshellarg($data);
					$url = escapeshellarg($url);

					exec($GatewaySettings['curl_location'] . " -k -d $data $url", $response);
					$response = implode($GatewaySettings['delim_char'], $response);
				}
				else
					$error = "MISSING_CURL";
			}
			else 
			{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_VERBOSE, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//				curl_setopt($ch, CURLOPT_PROXY,"http://xx.xx.xx.xx:xxxx"); // for hosts that need a curl proxy, replace the xx's
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  // To work for Windows 2003 
				$response = curl_exec($ch);
				curl_close($ch);
			}
		}
		
		return($error == "");
	}
?>