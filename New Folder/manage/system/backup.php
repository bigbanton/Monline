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
function _go_reload() {
	redirect($domain . '/manage/system/backup.php');
}

/* get tables */
$db_name = $INI['db']['name'];
$tables = DB::GetQueryResult("SHOW TABLE STATUS FROM `{$db_name}`", false);
/* end */

if (is_get()) {
	$results = DB::GetQueryResult("SHOW TABLE STATUS FROM `{$db_name}`", false);
	$option_table = Utility::OptionArray($results, 'name', 'name');
	die(include template('manage_system_backup'));
}

$type=$_POST['backup'];
if($type=="all"){
	if(!$_POST['multivolume']){
		$sql = null;
		foreach($tables AS $one) {
			$table = $one['name'];
			$sql .= backup_make_header($table);
			$query = DB::Query("SELECT * FROM `{$table}`");
			while($r = DB::NextRecord($query) ) {
				$sql .= backup_make_record($table, $r);
			}
		}
		$filename = date("Y_m_d_").Utility::GenSecret(4).'_all.sql';
		if($_POST['location']=="localpc") {
			backup_down_file($sql, $filename);
		}
		elseif($_POST['location']=="server"){
			if( true === backup_write_file($sql,$filename)) {
				Session::Set('notice', "Data backup is complete");
			}
			else {
				Session::Set('error', "Backup all data table failed");
			}
		}
		_go_reload();
	}else{
		if(!$_POST['filesize']){
			Session::Set('error', "Please fill in the sub-volume size of the backup file!");
			_go_reload();
		}

		$filenamep = date("Y_m_d_").Utility::GenSecret(4).'_all';
		$p=1; $sql = null;

		foreach($tables AS $one) {
			$table = $one['name'];
			$sql .= backup_make_header($table);
			$query = DB::Query("SELECT * FROM `{$table}`");
			while($r = DB::NextRecord($query) ) {
				$sql .= backup_make_record($table, $r);
				if(strlen($sql)>=$_POST['filesize']*1024){
					$filename = $filenamep  . ("_v".$p.".sql");
					if( true !== backup_write_file($sql,$filename)) {
						Session::Set('error',  "Backup failed");
						_go_reload();
					}
					$p++; $sql = null;
				}
			}
		}

		if($sql) {
			$filename = $filenamep  . ("_v".$p.".sql");
			if( true !== backup_write_file($sql,$filename)) {
				Session::Set('error', "Backup failed");
				_go_reload();
			}
		}

		Session::Set('notice', "Backup all data tables success!");
		_go_reload();
	}
} elseif($type=="single") {

	$table = mysql_escape_string(strval($_POST['tablename']));

	if(!$table) {
		Session::Set('error', "Please select the data to back up the table");
		_go_reload();
	}

	if(!$_POST['multivolume']){
		$sql = null;
		$sql .= backup_make_header($table);
		$query = DB::Query("SELECT * FROM `{$table}`");
		while($r = DB::NextRecord($query)){
			$sql .= backup_make_record($table, $r);
		}
		$filename = date("Y_m_d_").Utility::GenSecret(4)."_{$table}.sql";
		if($_POST['location']=="localpc") {
			backup_down_file($sql, $filename);
		}
		elseif($_POST['location']=="server"){
			if( true === backup_write_file($sql, $filename)) {
				Session::Set('notice', "Table-{$table}-Data backup is complete");
			} else {
				Session::Set('error', "BackUp table-{$table}-Failure");
			}
			_go_reload();
		}
	} else {
		if(!$_POST['filesize']){
			Session::Set('error', "Please fill in the sub-volume size of the backup file!");
			_go_reload();
		}

		$sql = null;
		$sql .= backup_make_header($table);
		$p=1;
		$filenamep = date("Y_m_d_").Utility::GenSecret(4)."_{$table}";

		$query = DB::Query("SELECT * FROM `{$table}`");
		while($r = DB::NextRecord($query)){
			$sql .= backup_make_record($table, $r);
			if(strlen($sql)>=$_POST['filesize']*1024){
				$filename = $filenamep . ("_v".$p.".sql");
				if( true !== backup_write_file($sql,$filename)){
					Session::Set('error',"Backup table-{$table}-{$p}-Failure");
					_go_reload();
				}
				$p++; $sql = null;
			}
		}

		if($sql) {
			if( true !== backup_write_file($sql,$filename)){
				Session::Set('error', "Backup table-{$table}-Failure");
				_go_reload();
			}
		}
		Session::Set('notice', "Table-{$table}-Data backup is complete");
		_go_reload();
	}

	if($_POST['location']=="localpc" && $_POST['multivolume']=='yes') {
		Session::Set('error', "Select the backup to the server,To use the sub-volume backup");
		_go_reload();
	}

	if($_POST['multivolume']=="yes" && !$_POST['filesize']) {
		Session::Set('error', "Select a sub-volume backup, file size does not fill in sub-volumes");
		_go_reload();
	}

	$backupdir = DIR_BACKEND . '/backup';

	if($_POST['location']=="server" && is_writeable($backupdir)) {
		Session::Set('error', "Backup files directory {$backupdir} Can not write, modify directory attributes");
		_go_reload();
	}
	_go_reload();
}
?>