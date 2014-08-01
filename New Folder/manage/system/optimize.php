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

ob_start();

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

$ob_content = ob_get_clean();

need_manager(true);
$module = 'system';
$optmsg = '';

$optmsg .= '<pre>' . "\n\n";

set_time_limit(100);

$time = microtime();

$time = explode(' ', $time);

$time = $time[1] + $time[0];

$start = $time;

$config_file = SYS_PHPFILE;

// Connection variables :
if (file_exists($config_file))
    
     {
    
    require($config_file);
    
     } 

else
    
     {
    
    echo 'System read error. Contact the administrator for help.';
    
     exit;
    
     } 

$h = $INI['db']['host'];

$u = $INI['db']['user'];

$p = $INI['db']['pass'];

$dummy_db = $INI['db']['name']; //The php->mysql API needs to connect to a database even when executing scripts like this. If you got an error from this(permissions), just replace this with the name of your database

$db_link = mysql_connect($h, $u, $p);

$res = @mysql_db_query($dummy_db, 'SHOW DATABASES', $db_link) or die('Could not connect: ' . mysql_error());

$optmsg .= 'Found ' . mysql_num_rows($res) . ' databases' . "\n";

$dbs = array();

while ($rec = mysql_fetch_array($res))

 {
    
    $dbs [] = $rec [0];
    
    } 

foreach ($dbs as $db_name)

 {
    
    $optmsg .= "Database : $db_name \n\n";
    
    $res = @mysql_db_query($dummy_db, "SHOW TABLE STATUS FROM `" . $db_name . "`", $db_link) or die('Query : ' . mysql_error());
    
    $to_optimize = array();
    
    while ($rec = mysql_fetch_array($res))
    
     {
        
        if ($rec['Data_free'] > 0)
        
         {
            
            $to_optimize [] = $rec['Name'];
            
            $optmsg .= $rec['Name'] . ' needed optimization' . "\n";
            
            } 
        
        } 
    
    if (count ($to_optimize) > 0)
        
         {
        
        foreach ($to_optimize as $tbl)
        
         {
            
            @mysql_db_query($db_name, "OPTIMIZE TABLE `" . $tbl . "`", $db_link);
            
            $optmsg .= "\n" . "Table " . $tbl . " optimized successfully" . "\n";
            
            } 
        
        } 
    
    else {
        
        $optmsg .= 'Congratulations! All tables in the database are optimized for the performance.' . "\n\n\n";
        
        } 
    
    } 

$time = microtime();

$time = explode(' ', $time);

$time = $time[1] + $time[0];

$finish = $time;

$total_time = round(($finish - $start), 6);

$optmsg .= "\n" . 'Parsed in ' . $total_time . ' secs' . "\n\n";

$optmsg .= '</pre>';

include template('manage_system_optimize');
