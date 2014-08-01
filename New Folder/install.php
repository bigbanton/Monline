<?php
/**
 * //License information must not be removed.
 * PHP version 5.2x
 *
 * @category	### Gripsell ###
 * @package		### Advanced ###
 * @arch		### Secured  ###
 * @author 		Development Team, Gripsell Technologies & Consultancy Services
 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell Tech}
 * @license		http://www.gripsell.com Clone Portal
 * @version		4.3.2
 * @since 		2011-08-23
 */
$FIRST_LOAD_INSTALL=1;
$mca4ssd = 'install288';
include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/ossetup.php');

if (!is_writable(DIR_BACKEND . '/install/')) die('Folder '.DIR_BACKEND . '/install/ is not writable or BACKEND folder path is not defined correctly');

include_once(dirname(__FILE__) . '/functions/include/classes/ZProcess.class.php');
include_once(dirname(__FILE__) . '/functions/include/modules/template.php');
header('Content-Type: text/html; charset=UTF-8;');
Session::Init();

if (is_get() ) {

		$db = array(
		'host' => $mydef_dbhost,
		'user' => $mydef_dbuser ,
		'pass' => $mydef_dbpass,
		'name' => $mydef_dbname ,
    );
	if (!is_writable(DIR_BACKEND . '/phpcache')) {
		echo 'Error: "' . DIR_BACKEND . '"  - this folder and its sub-folders must be writable'."<br/><br/>";
		echo '<p style="font-family:Arial; color:#006699;font-size:12px;">Common reasons for this error:<br/>
				<ul style="font-family:Arial; color:#006699;font-size:12px;">
				<li>Root path to backend folder is incorrect.';
			
			if (findbackend()) echo 'It looks like your backend folder path is <span style="font-weight:bold;color:#CC3300">'. findbackend(). '</span> -- Make sure this is correct before using it.';	
				
		echo	'</li>
				<li>"Backend" folder and its sub-folders do not have write permission (CHMOD 0777).</li>
				<li>You have renamed "Backend" folder but did not update config.php file accrodingly.</li>
				</ul>
			</p>
		';
		exit();
	}
	die(include template('install_step'));
}
$db = $_POST['db'];

$m = mysql_connect($db['host'], $db['user'], $db['pass']);

if ($err) {
echo $err;
exit;
	Session::Set('error', $err);
	Utility::Redirect('install.php');
}

if (!is_writable(DIR_BACKEND . '/configure/') ) {
	Session::Set('error', DIR_BACKEND . '/configure/ Write forbidden');
	Utility::Redirect('install.php');
}

if (!is_writable(DIR_BACKEND . '/install/') ) {
	Session::Set('error', DIR_BACKEND . '/install/ Write forbidden');
	Utility::Redirect('install.php');
}

if (!is_writable(DIR_BACKEND . '/data/') ) {
	Session::Set('error', DIR_BACKEND . '/data/ Write Forbidden');
	Utility::Redirect('install.php');
}

if (!is_writable(DIR_BACKEND . '/themes/deals/') ) {
	Session::Set('error', DIR_BACKEND . '/deals/ Write Forbidden');
	Utility::Redirect('install.php');
}
if (!is_writable(DIR_BACKEND . '/themes/user/') ) {
	Session::Set('error', DIR_BACKEND . '/themes/user/ Write Forbidden');
	Utility::Redirect('install.php');
}

if ( !mysql_select_db($db['name'], $m)
		&& !mysql_query("CREATE database `{$db['name']}`;", $m) ) {
	Session::Set('error', "Select database {$db['name']} Error, make sure you have created it?");
	Utility::Redirect('install.php');
}
mysql_select_db($db['name'], $m);

//$sql = (isset($_POST['sampledata']) && $_POST['sampledata']=='yes') ? configdb('dealsam433') : configdb('install433');
//echo $_POST['sampledata'];exit;
$sql = (isset($_POST['sampledata']) && $_POST['sampledata']=='yes') ? readsqlfile('dealsam433') : readsqlfile('install433');
//echo $sql;
//exit();
			//$filename = DIR_BACKEND . '/configure/db.sql';
			//$fd = fopen ($filename, "r");
			//$contents = fread ($fd, filesize($filename));
			//fclose ($fd);
			//$contents= $sql;
			//$fp = fopen ($filename, "w");
			//fwrite ($fp,$contents);
			//fclose ($fp);

$dir = dirname(__FILE__);

if (file_exists(DIR_BACKEND . '/configure/db.sql')) { @unlink(DIR_BACKEND . '/configure/db.sql'); }

$splitter = (isset($_POST['sampledata']) && $_POST['sampledata']=='yes') ? ";" : ";";
mysql_query("SET names UTF8;");
$sqls = explode($splitter, $sql);
//print_r($sqls);exit;
$index=0;
foreach($sqls AS $sql) {
	
	mysql_query($sql, $m);
	//if (mysql_error()) { echo mysql_error();exit; }
}

$PHP = array(
	'db' => $db,
);

if ($results["status"]=="Active") {
		$sql = "Select value from `administration` where id='sitename';";
		$result = mysql_query($sql, $m);
		$db_field = mysql_fetch_assoc($result);
		
		if (!$db_field) {
			$sql = "INSERT INTO `administration` (`id`, `value`) VALUES ('licensekey', '{$licensekey}'), ('sitekey', '{$results["localkey"]}'), ('sitename', 'R3JpcHNlbGwgVGVjaG5vbG9naWVz');";
			mysql_query($sql, $m);
		}
		
		//if ($_POST['sampledata']=='yes') updatesample();
}

if ( write_php_file($PHP, SYS_PHPFILE) ) {
	if ($_POST['sampledata']=='yes') {
		Session::Set('notice', 'Installation is now complete. Admin Login: Username - \'info@cloneportal.com\' Password - \'demopro\'.');
	} else {
		Session::Set('notice', 'Installation is now complete. Register now for your \'Super Admin\' account. Click \'Register\' button on top right.');
	}
}

$FIRST_LOAD_INSTALL=0;
$firststr = ($_POST['sampledata']=='yes')?'index.php?first&sampledata':'index.php?first';
Utility::Redirect($firststr);

function findbackend() {
	if (is_dir(dirname(__FILE__) . '/backend')) {
		return dirname(__FILE__) . '/backend';
	} elseif (is_dir(dirname(dirname(__FILE__)) . '/backend')) {
			return dirname(dirname(__FILE__)) . '/backend'; 	
	} elseif (is_dir(dirname(dirname(dirname(__FILE__))) . '/backend')) {
			return dirname(dirname(dirname(__FILE__))) . '/backend'; 
	}
	return 0;
}

function updatesample() {
	   	$m = mysql_connect($db['host'], $db['user'], $db['pass']);
		mysql_select_db($db['name'], $m);
		$newtime = mktime(0, 0, 0, date("m") , date("d"), date("Y"));
		$newtimeplus = $newtime + 172800 + 86400;
		$newtimepp = $newtimeplus + 10000;
		$newtimeppp = $newtimepp + 60000;
		$newtimepppp = $newtimeppp + 80000;

		$oldtime = $newtime - 172800;
		$oldtimeplus = $newtime;
		$futuretime = $newtimeplus;
		$futuretimeplus = $futuretime + 172800;
		$expiretime = $newtime + (30 * 172800);

		$sql = "UPDATE `deals` SET `begin_time` = '" . $newtime . "', `end_time` = '" . $newtimeplus . "', `expire_time` = '" . $expiretime . "' WHERE `id` = '1'";
		@mysql_query($sql);
		
		$sql = "UPDATE `insta` SET `begin_time` = '" . $newtime . "', `end_time` = '" . $newtimeplus . "' WHERE `id` = '1'";
		@mysql_query($sql);

}

function readsqlfile($getsqlcontent)
{
	//echo $getsqlcontent;exit;
if($getsqlcontent == 'dealsam433')
{
	//echo "success";exit;
		
		if (file_exists(DIR_BACKEND . '/configure/gripsell_adv_sample_data.sql'))
		 { 
		 
		 //echo "Hi";exit;
		
		$sql_read =	file_get_contents(DIR_BACKEND . '/configure/gripsell_adv_sample_data.sql');
			//print_r($sql_read);exit;	
		 }
		 
		 else 
		 
		 {
			 //echo "Kranthi";exit;
	Session::Set('error', DIR_BACKEND . '/data/ Sample data File does not exist');
	Utility::Redirect('install.php');
			 
		 }
			   
}
			   
else
   
{
         if (file_exists(DIR_BACKEND . '/configure/gripsell_adv_no_sample_data.sql'))
         { 
		 //echo "HI";exit;
		$sql_read =	file_get_contents(DIR_BACKEND . '/configure/gripsell_adv_no_sample_data.sql');
		//print_r($sql_read);exit;
		 }
		 
		 else 
		 {
			 //echo "ethan";exit;
	Session::Set('error', DIR_BACKEND . '/data/ No Sample data File does not exist');
	Utility::Redirect('install.php');
			 
		 }
			   
}
	
	
	return $sql_read;
	
}

?>
