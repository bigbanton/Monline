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

	 

	ob_start();

	require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

	$ob_content = ob_get_clean();

	

	need_manager(true);
$module = 'system';
	$system = Table::Fetch('system', 1);

	

	include_once(dirname(dirname(__FILE__)) . '/config.php');

	$tmpfilename	=	DIR_BACKEND.'/data/cache/';

	

	$strCsvFile		=	$_GET["file"];

	$strLetter		=	$_GET["letter"];

	// we have added the language translation patches ... updated by pavan . 15-02-2013.

	if($_POST) {
		
		//var_dump($_POST["frm_language_phrase"]);

		$path  = DIR_BACKEND . '/data/cache'."/".$strCsvFile.".lng";

		$strLanguagePhrase	=	$_POST["frm_language_phrase"];
		//var_dump($strLanguagePhrase);

		$strLanguageEdit	=	$_POST["frm_language_edit"];

		$strLanguageLabel	=	$_POST["frm_language_label"];

		

		$strValue = array();
		 //phpinfo();

 $z = count($_REQUEST["frm_language_phrase"]);
		//echo $z = count($strLanguagePhrase);
		

		for($z=0;$z<count($strLanguagePhrase);$z++) {

			if($strLanguageEdit[$z]=='yes') {

				$strValue[$z]	=	stripslashes($strLanguageLabel[$z]).';'.stripslashes($strLanguagePhrase[$z]);
				//echo "strValue[$z]--->$strValue[$z]..";
			} else {

				$strValue[$z]	=	stripslashes($strLanguagePhrase[$z]);
				//echo "strValue[$z]--->$strValue[$z]..";
			}	
			
			

		}	
		/*for($i=0;$i<count($strValue);$i++)
		{
			echo "[$i]--->>$strValue[$i]...<br>";
		}*/
		//..... writing outside of loop due to performance issue....	
			$value = implode("\n", $strValue);

			ZLanguageTranslate::writeFileContent($path, $value);
		Session::Set('notice', 'Language Translation has been updated');

	}



	if(is_dir($tmpfilename)) {

		$strLangFiles	=	ZLanguageTranslate::getCSVFiles($tmpfilename);

	}

	

	$strPostFilename	=	$strCsvFile.'.lng';	

	if($strCsvFile) {

		$srcfiles	=	$tmpfilename.$strPostFilename;		

		if($srcfiles!='') {

			$records	=	ZLanguageTranslate::getCsvDatas($srcfiles);

			if($records) {

				$strPhrases	=	ZLanguageTranslate::getLanguageDatas($records,$strLetter);
				//var_dump($strPhrases);

			}

		}

	}	

	

	$strAlphabet =	ZLanguageTranslate::getAlphabets();

	include template('manage_system_translate');

?>