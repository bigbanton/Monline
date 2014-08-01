<?php

/**

 * //License information must not be removed.

 * PHP version 5.2x

 *

 * @category	### Gripsell ###

 * @package		### Advanced ###

 * @arch		### Secured  ###

 * @author 		Development Team, Gripsell Technologies & Consultancy Services

 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}

 * @license		http://www.gripsell.com Clone Portal

 * @version		4.3.2

 * @since 		2011-08-23

 */

class ZLanguageTranslate {



	static public function getLanguageDatas($strphrases,$strLetter='') {

		

		$inc = 0;

		$pre = 0;

		$preno = 0;

		$num = 0;

		$strPhrasesDetails = array();

		

		for($m=0;$m<count($strphrases);$m++) {

			$strphrases[$m]["Phrases"]	=	explode(";",$strphrases[$m][0]);

			$strLangValues				=	substr($strphrases[$m]["Phrases"][0],0,1);

			$strSelectedLetter			=	$strLetter;

			$strNumbers					=	'no';

			

			if($strSelectedLetter=='0-9') {

				$strNumbers	=	'yes';

				$strNumerics				=	array(0,1, 2, 3, 4, 5, 6, 7, 8, 9);

			}

			

	if($strSelectedLetter) 
	
	{
				// we have added the language translation patches ... updated by pavan . 15-02-2013.
				//if($strLangValues==$strSelectedLetter && $strNumbers=='no') {
					
					if(strcasecmp($strLangValues,$strSelectedLetter)==0 && $strNumbers=='no') {

					$strPhrasesDetails[$m]["0"]						=	$strphrases[$m]["0"];

					$strPhrasesDetails[$m]["Phrases"]				=	$strphrases[$m]["Phrases"];

					$strPhrasesDetails[$m]["selectedphrases"]		=	stripslashes($strphrases[$m]["Phrases"][0]);

					$strPhrasesDetails[$m]["strAvailablePhrase"]	=	'yes';

					$inc++;

				} 
				else if($strNumbers=='yes' && is_numeric($strLangValues)) {	

							if(in_array($strLangValues,$strNumerics)) {			

							$strPhrasesDetails[$m]["0"]						=	$strphrases[$m]["0"];

							$strPhrasesDetails[$m]["Phrases"]				=	$strphrases[$m]["Phrases"];

							$strPhrasesDetails[$m]["selectedphrases"]		=	stripslashes($strphrases[$m]["Phrases"][0]);

							$strPhrasesDetails[$m]["strAvailablePhrase"]	=	'yes';

							$num++;

							}

				} 
				else {

					$strPhrasesDetails[$m]["0"]						=	$strphrases[$m]["0"];

					$strPhrasesDetails[$m]["Phrases"]				=	$strphrases[$m]["Phrases"];

					$strPhrasesDetails[$m]["otherphrases"]			=	stripslashes($strphrases[$m][0]);

					$strPhrasesDetails[$m]["strAvailablePhrase"]	=	'no';

					$preno++;

				}

	} 
			else {

				$strPhrasesDetails[$m]["0"]						=	$strphrases[$m]["0"];

				$strPhrasesDetails[$m]["Phrases"]				=	$strphrases[$m]["Phrases"];

				$strPhrasesDetails[$m]["selectedphrases"]		=	stripslashes($strphrases[$m]["Phrases"][0]);

				$strPhrasesDetails[$m]["strAvailablePhrase"]	=	'yes';

				$pre++;

			}

		}

		if($inc==0 && $pre==0 && $num==0) {

			return 0;

		} else {

			return $strPhrasesDetails;

		}

	}

	static public function writeFileContent($file, $content){

		$fp = fopen($file, 'w+');

		fwrite($fp, $content);

		fclose($fp);

		return true;

	}

	static public function getCSVFiles($tmpfilename){

		$dir_handle  = opendir($tmpfilename) or die("Unable to open");

		while ($file = readdir($dir_handle)){

			$strFiles[]	=	$file;

		}

		$strCount	=	count($strFiles);

		$int = 0;

		for($k=0;$k<$strCount;$k++) {

			if($strFiles[$k]!="." && $strFiles[$k]!=".." && !is_dir("$tmpfilename/$strFiles[$k]")) {

				$strGetLanguage[]	=	$strFiles[$k];

				$int++;

			}

		}

		sort($strGetLanguage);

		foreach ($strGetLanguage as $key => $val) {

			$strreplace	=	str_replace(".lng","",$val);

			$strLangFiles[$strreplace] =	$val;

		} 

		return $strLangFiles;

	}

	static public function getAlphabets(){

		$strAlphabet = array('0_9' => '0-9','a' => 'A', 'b'=>'B', 'c'=>'C','d' => 'D', 'e'=>'E', 'f'=>'F','g' => 'G', 'h'=>'H', 'i'=>'I','j' => 'J', 'k'=>'K', 'l'=>'L', 'm'=>'M', 'n'=>'N', 'o'=>'O', 

		'p'=>'P','q' => 'Q', 'r'=>'R', 's'=>'S','t' => 'T', 'u'=>'U', 'v'=>'V','w' => 'W', 'x'=>'X', 'y'=>'Y','z'=>'Z');

		return $strAlphabet;

	}	

	

	static public function getCsvDatas($srcfiles){

		/*$handle = fopen($srcfiles, "r");

		while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {

			$records[] = $data;
			}

		return $records;*/
		
		
		// we have added the language translation patches ... updated by pavan . 15-02-2013.
			
			
							$str=file_get_contents($srcfiles);
							$str=preg_replace('/\n/','@@',$str);
							$records=array();
							$str1=explode('@@',$str);
							foreach($str1 as $k=>$v)
							{
								$records[$k][0]=$v;
							}
							
							return $records;

		

	}

	

	static public function recursiveArraySearch($haystack, $needle, $index = null) { 

    $aIt     = new RecursiveArrayIterator($haystack); 

    $it    = new RecursiveIteratorIterator($aIt); 

    

    while($it->valid()) 

    {        

        if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) { 

            return $aIt->key(); 

        } 

        

        $it->next(); 

    } 

		return false; 

	}

	

	

	static public function in_multiarray($elem, $array)

    {

        // if the $array is an array or is an object

         if( is_array( $array ) || is_object( $array ) )

         {

             // if $elem is in $array object

             if( is_object( $array ) )

             {

                 $temp_array = get_object_vars( $array );

                 if( in_array( $elem, $temp_array ) )

                     return TRUE;

             }

            

             // if $elem is in $array return true

             if( is_array( $array ) && in_array( $elem, $array ) )

                 return TRUE;

                

            

             // if $elem isn't in $array, then check foreach element

             foreach( $array as $array_element )

             {

                 // if $array_element is an array or is an object call the in_multiarray function to this element

                 // if in_multiarray returns TRUE, than the element is in array, else check next element

                 if( ( is_array( $array_element ) || is_object( $array_element ) ) && in_multiarray( $elem, $array_element ) )

                 {

                     return TRUE;

                     exit;

                 }

             }

         }

        

         // if isn't in array return FALSE

         return FALSE;

    }

}

?>