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

require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();

// ############ PUSH SPECIFIC DEAL ##############
// Set this to the deal id that you want to push
// to the widget. For default deal, set it back
// to 0

$push_deal_id = 0;

// ############ PUSH SPECIFIC DEAL #############

// DO NOT EDIT BELOW THIS LINE

if (!$deals = current_deals($city['id'])) {
    
    $deals = current_deals('0');
    
    } 

if ($deals && !$_GET['id']) $_GET['id'] = abs(intval($deals['id']));

if ($push_deal_id) $_GET['id'] = $push_deal_id;

$id = abs(intval($_GET['id']));

if ($id) {
    
    
    
    $oc = array(
        
        
        
        "(city_id = '0' OR find_in_set({$city['id']},city_id))",
        
        
        
         'id' => $id,
        
        
        
         "begin_time < {$now}",
        
        
        
         "end_time > {$now}",
        
        
        
         'stage' => array('1-featured', 'approved'),
        
        
        
        );
    
    
    
    } else {
    
    
    
    $oc = array(
        
        
        
        "(city_id = '0' OR find_in_set({$city['id']},city_id))",
        
        
        
         "begin_time < {$now}",
        
        
        
         "end_time > {$now}",
        
        
        
         'stage' => array('1-featured', 'approved'),
        
        
        
        );
    
    } 

$deals = DB::LimitQuery('deals', array(
        
        'condition' => $oc,
        
         'size' => 1,
        
         'order' => 'ORDER BY stage',
        
        ));

if ($deals) $deals = $deals[0];

$partner = Table::Fetch('partner', $deals['partner_id']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $deals['title'] ?></title>

<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="deal-wrapper">

  <div id="logo"> <a href="http://www.realdealstl.com"><img src="images/logo.png" width="178" height="77" /></a></div>

  <div id="deal-content">

    <h1><?php echo '<a style="color:#000;text-decoration:none;" target="_parent" href="http://www.realdealstl.com/deals.php?id=' . $deals['id'] . '">';
echo substr($deals['title'], 0, 100);
echo (strlen($deals['title']) > 100)? '...':'';
echo '</a>';
?></h1>

    <div class="deal-banner">

      <div class="deal-banner-price"><?php echo $currency . $deals['deals_price'];
?></div>

      <div style="position:absolute; top:60px; left:12px; font:bold 16px Arial, Helvetica, sans-serif; color:#fff; text-align:center; width: 181px; height: auto;"><?php echo $partner['title'];
?></div>

      <div style="position:absolute; top:18px; left:206px; font:bold 16px Arial, Helvetica, sans-serif; color:#fff; text-align:center; width: 200px; height: 140px; overflow:hidden"><?php echo '<a style="color:#000;text-decoration:none;" target="_parent" href="http://www.realdealstl.com/deals.php?id=' . $deals['id'] . '">';
?><img style="border-width:0;left:0px;top:0px;width:200px;height:140px;" src="<?php echo deals_image($deals['image']);
?>" alt="" /><?php echo '</a>';
?></div>

      <img src="images/heeb-chiropractic.png" width="419" height="171" /></div>

    <div class="buy-button"> <a href="http://www.realdealstl.com/manage/deals/buy.php?id=<?php echo $deals['id'] ?>" target="_parent"><img src="images/buy-button.png" width="165" height="41" /></a></div>

    <div class="sign-up"> <a href="http://www.realdealstl.com/account/signup.php" target="_parent"><img src="images/sign-up-button.png" width="68" height="24" /></a></div>

  </div>

</div>

</body>

</html>