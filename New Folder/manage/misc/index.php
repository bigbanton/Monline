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

need_manager();
$module = 'home';
$user = Table::Fetch('user', $login_user_id, 'id');

$oc = array(
    
    'userid' => 1,
    
     'description' => 'Login',
    
    );

$last_login_time = DB::LimitQuery('log', array('condition' => $oc, 'size' => 1, 'order' => 'ORDER BY id DESC'));

$last_login_stamp = ($last_login_time[0]['datetime'])? date("l F j, Y h:iA", $last_login_time[0]['datetime']):'N/A';

$daytime = strtotime(date('Y-m-d'));

$deals_count = Table::Count('deals');

$order_count = Table::Count('order');

$user_count = Table::Count('user');

$subscribe_count = Table::Count('subscribe');

$order_today_count = Table::Count('order', array(
        
        "create_time > {$daytime}",
        
        ));

$user_today_count = Table::Count('user', array(
        
        "create_time > {$daytime}",
        
        ));

$date = getdate();

$dayofmonth = $date['mday'];

list($year, $month) = explode('-', date('Y-n'));

$last_date_of_month = lastOfMonth();

// $month=$month-1;

// ########################### JSON DATA CALL RECEPTORS ###############################

$periodtype = $_GET['period'];

switch ($periodtype) {

case 'Monthly':
    
     $period = 12; //$month;
    
    
     break;

 default:
    
     $period = lastOfMonth();
    
    } 

// RECEPTOR FOR JSON CALL FOR MONTHLY ORDERS
if ($_GET['do'] == 'action' && $_GET['action'] == 'order') {

for ($i = 1; $i <= $period; $i++) {

if ($periodtype == 'Monthly') {

$starttime = strtotime(date($year . '-' . $i . '-01'));

 $endtime = strtotime(date($year . '-' . $i . '-' . lastOfMonth($i)));

 } else {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = $starttime + 86399;

 } 

// For Regular Deals
$oc = array ("AND" => array("create_time > {$starttime} AND create_time < {$endtime}", 'isinsta' => 0, 'state' => 'pay'),

);

 $order_deals_monthly_count = Table::Count('order', $oc);

 $order_deals_monthly_sum = Table::Count('order', $oc, 'price');

 $flotdealsdata .= "[{$i},$order_deals_monthly_count],";

 // For Insta Deals
$oc = array ("AND" => array("create_time > {$starttime} AND create_time < {$endtime}", 'isinsta' => 1, 'state' => 'pay'),

);

 $order_insta_monthly_count = Table::Count('order', $oc);

 $order_insta_monthly_sum = Table::Count('order', $oc, 'price');

 $flotinstadata .= "[{$i},$order_insta_monthly_count],";

 } 

if (isset($_GET['type']) && $_GET['type'] == 'insta') {

echo '{

			"label": "Insta Deals Orders",

			"data": [' . rtrim($flotinstadata, ",") . ']

		}';

 } else {

echo '{

			"label": "Regular Deals Orders",

			"data": [' . rtrim($flotdealsdata, ",") . ']

		}';

 } 

exit();

} 

// RECEPTOR FOR JSON CALL FOR MONTHLY DEALS
if ($_GET['do'] == 'action' && $_GET['action'] == 'deal') {

for ($i = 1; $i <= $period; $i++) {

if ($periodtype == 'Monthly') {

$starttime = strtotime(date($year . '-' . $i . '-01'));

 $endtime = strtotime(date($year . '-' . $i . '-' . lastOfMonth($i)));

 } else {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = $starttime + 86399;

 } 

// For Regular Deals
$oc = array (

"OR" => array(
    
    "stage" => "approved",
    
     "stage" => "1-featured",
    
    ),

 "OR" => array(
    
    "begin_time > {$starttime} AND begin_time < {$endtime}",
    
    ),

);

 $order_deals_monthly_count = Table::Count('deals', $oc);

 $order_deals_monthly_sum = Table::Count('deals', $oc, 'price');

 $flotdealsdata .= "[{$i},$order_deals_monthly_count],";

 // For Insta Deals
$oc = array (

"OR" => array(
    
    "stage" => "approved",
    
     "stage" => "1-featured",
    
    ),

 "OR" => array(
    
    "begin_time > {$starttime} AND begin_time < {$endtime}",
    
    ),

);

 $order_insta_monthly_count = Table::Count('insta', $oc);

 $order_insta_monthly_sum = Table::Count('insta', $oc, 'price');

 $flotinstadata .= "[{$i},$order_insta_monthly_count],";

 } 

if (isset($_GET['type']) && $_GET['type'] == 'insta') {

echo '{

			"label": "New Insta Deals",

			"data": [' . rtrim($flotinstadata, ",") . ']

		}';

 } else {

echo '{

			"label": "New Regular Deals",

			"data": [' . rtrim($flotdealsdata, ",") . ']

		}';

 } 

exit();

} 

// RECEPTOR FOR JSON CALL FOR MONTHLY USERS
if ($_GET['do'] == 'action' && $_GET['action'] == 'user') {

for ($i = 1; $i <= $period; $i++) {

if ($periodtype == 'Monthly') {

$starttime = strtotime(date($year . '-' . $i . '-01'));

 $endtime = strtotime(date($year . '-' . $i . '-' . lastOfMonth($i)));

 } else {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = $starttime + 86399;

 } 

// For New Users
$user_monthly_count = Table::Count('user', array(
    
    "create_time >= {$starttime}", "create_time < {$endtime}",
    
    ));

 $flotnewuserdata .= "[{$i},$user_monthly_count],";

 // For Active Users
$user_monthly_count = Table::Count('user', array(
    
    "login_time >= {$starttime}", "login_time < {$endtime}",
    
    ));

 $flotactiveuserdata .= "[{$i},$user_monthly_count],";

 } 

if (isset($_GET['type']) && $_GET['type'] == 'newuser') {

echo '{

			"label": "New Users",

			"data": [' . rtrim($flotnewuserdata, ",") . ']

		}';

 } else {

echo '{

			"label": "Active Users",

			"data": [' . rtrim($flotactiveuserdata, ",") . ']

		}';

 } 

exit();

} 

// ########################### DASHBOARD DATA LOAD ###############################

// For new users
$flotdata = '';

for ($i = 1; $i <= $last_date_of_month; $i++)

 {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = strtotime(date($year . '-' . $month . '-' . $i)) + 86399;

 $order_day_count = Table::Count('user', array(

"create_time >= {$starttime}", "create_time < {$endtime}",

));

 $flotdata .= "[{$i},$order_day_count],";

} 

$flotdata_newusers = rtrim($flotdata, ",");

// For active users
$flotdata = '';

for ($i = 1; $i <= $last_date_of_month; $i++)

 {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = strtotime(date($year . '-' . $month . '-' . $i)) + 86399;

 $order_day_count = Table::Count('user', array(

"login_time >= {$starttime}", "login_time < {$endtime}",

));

 $flotdata .= "[{$i},$order_day_count],";

} 

$flotdata_activeusers = rtrim($flotdata, ",");

// New regular deals
$flotdata = '';

for ($i = 1; $i <= $last_date_of_month; $i++)

 {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = strtotime(date($year . '-' . $month . '-' . $i)) + 86399;

 $oc = array (

"OR" => array(

"stage" => "approved",

 "stage" => "1-featured",

),

 "OR" => array(

"begin_time > {$starttime} AND begin_time < {$endtime}",

),

);

 // echo DB::BuildCondition( $oc );exit;
// $condition = "`stage` = 'approved' AND ((begin_time <= {$starttime} AND end_time > {$starttime}) OR (end_time > {$endtime} AND begin_time <= {$endtime})OR (begin_time >= {$starttime} AND end_time <= {$endtime})) Group by stage";
$deal_day_count = Table::Count('deals', $oc);

 $flotdata .= "[{$i},$deal_day_count],";

} 

$flotdata_regulardeals = rtrim($flotdata, ",");

// New insta deals
$flotdata = '';

for ($i = 1; $i <= $last_date_of_month; $i++)

 {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = strtotime(date($year . '-' . $month . '-' . $i)) + 86399;

 $oc = array (

"OR" => array(

"stage" => "approved",

 "stage" => "1-featured",

),

 "OR" => array(

"begin_time > {$starttime} AND begin_time < {$endtime}",

),

);

 $deal_day_count = Table::Count('insta', $oc);

 $flotdata .= "[{$i},$deal_day_count],";

} 

$flotdata_instadeals = rtrim($flotdata, ",");

// For new daily deals orders
$flotdata = '';

$order_deals_today = 0;

$order_deals_month = 0;

for ($i = 1; $i <= $last_date_of_month; $i++)

 {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = $starttime + 86399;

 $yesterday_starttime = $starttime-86400;

 $yesterday_endtime = $starttime-1;

 $oc = array ("AND" => array("create_time > {$starttime} AND create_time < {$endtime}", 'isinsta' => 0, 'state' => 'pay'),

);

 $order_deals_day_count = Table::Count('order', $oc);

 $order_deals_day_sum = Table::Count('order', $oc, 'price');

 $order_deals_month += $order_deals_day_sum;

 $order_deals_month_count += $order_deals_day_count;

 if ($i == $dayofmonth) {

$order_deals_today = $order_deals_day_sum;

 // Yesterdays Orders
$oc = array ("AND" => array("create_time > {$yesterday_starttime} AND create_time < {$yesterday_endtime}", 'isinsta' => 0, 'state' => 'pay'),

);

 $order_deals_yesterday_count = Table::Count('order', $oc);

 } 

$flotdata .= "[{$i},$order_deals_day_count],";

} 

$flotdata_instadealsorders = rtrim($flotdata, ",");

// For new insta deals orders
$flotdata = '';

$order_insta_today = 0;

$order_insta_month = 0;

for ($i = 1; $i <= $last_date_of_month; $i++)

 {

$starttime = strtotime(date($year . '-' . $month . '-' . $i));

 $endtime = $starttime + 86399;

 $yesterday_starttime = $starttime-86400;

 $yesterday_endtime = $starttime-1;

 $oc = array ("AND" => array("create_time > {$starttime} AND create_time < {$endtime}", 'isinsta' => 1, 'state' => 'pay'),

);

 $order_insta_day_count = Table::Count('order', $oc);

 $order_insta_day_sum = Table::Count('order', $oc, 'price');

 $order_insta_month += $order_insta_day_sum;

 $order_insta_month_count += $order_insta_day_count;

 if ($i == $dayofmonth) {

$order_insta_today = $order_insta_day_sum;

 // Yesterdays Orders
$oc = array ("AND" => array("create_time > {$yesterday_starttime} AND create_time < {$yesterday_endtime}", 'isinsta' => 1, 'state' => 'pay'),

);

 $order_insta_yesterday_count = Table::Count('order', $oc);

 } 

$flotdata .= "[{$i},$order_insta_day_count],";

} 

$flotdata_newinstaorders = rtrim($flotdata, ",");

// Get year order value for regular deals
 $starttime = strtotime(date($year . '-01-01'));

 $endtime = strtotime(date($year . '-' . $month . '-' . $dayofmonth)) + 86400;

 $oc = array ("AND" => array("create_time > {$starttime} AND create_time < {$endtime}", 'isinsta' => 0, 'state' => 'pay'),

);

 $order_deals_year_count = Table::Count('order', $oc);

 $order_deals_year = Table::Count('order', $oc, 'price');

// Get year order value for insta deals
 $starttime = strtotime(date($year . '-01-01'));

 $endtime = strtotime(date($year . '-' . $month . '-' . $dayofmonth)) + 86400;

 $oc = array ("AND" => array("create_time > {$starttime} AND create_time < {$endtime}", 'isinsta' => 1, 'state' => 'pay'),

);

 $order_insta_year_count = Table::Count('order', $oc);

 $order_insta_year = Table::Count('order', $oc, 'price');

// Add deals + insta

$order_year = $order_deals_year + $order_insta_year;

$order_month = $order_deals_month + $order_insta_month;

$order_today = $order_deals_today + $order_insta_today;

// Define required functions

function lastOfMonth($month = 0)
{

 if (!$month) $month = date('m');

 return date("d", strtotime('-1 second', strtotime('+1 month', strtotime($month . '/01/' . date('Y') . ' 00:00:00'))));

} 

$activity = DB::LimitQuery('log', array(

'order' => 'ORDER BY id DESC',

 'size' => 25,

));

$recent_errors = DB::LimitQuery('log', array(

'condition' => array('error' => '1',),

 'order' => 'ORDER BY id DESC',

 'size' => 25,

));

include template('manage_misc_index');

