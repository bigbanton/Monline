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

need_login();

$ob_content = ob_get_clean();

$id = abs(intval($_GET['id']));

$dbname = ($_REQUEST['isinsta']) ? 'insta' : 'deals';

$deals = Table::Fetch($dbname, $id);

if (!$deals) {
    
    die('404 Not Found');
    
    } 

if ($_POST) {
    
    need_login(true);
    
     $table = new Table('order', $_POST);
    
     if ($table->quantity < 1) {
        
        $table->quantity = 1;
        
         // Session::Set('error', TEXT_EN_CANNOT_BUY_LESS_THAN_1_EN);
        // Utility::Redirect( BASE_REF . "/manage/deals/buy.php?id={$deals['id']}");
        } 
    
    
    
    if ($_REQUEST['isinsta']) { // Instant Deal
        
        
        
        $table->user_id = $login_user_id;
        
         $table->deals_id = $deals['id'];
        
         $table->city_id = $deals['city_id'];
        
         $table->create_time = time();
        
         $table->origin = $table->quantity * $deals['deals_price'];
        
         $table->price = $table->quantity * $deals['deals_price'];
        
         $table->isinsta = 1;
        
         $table->express = 'N';
        
         $table->credit = 0;
        
        
        
         $insert = array(
            
            'user_id', 'deals_id', 'city_id', 'state',
            
             'origin', 'express', 'credit',
            
             'address', 'zipcode', 'quantity',
            
             'create_time', 'price', 'isinsta',
            
            );
        
         $flag = $table->update($insert);
        
        
        
         if ($flag = $table->update($insert)) {
            
            if ($table->id) Utility::Redirect(BASE_REF . "/account/order/check.php?id={$table->id}");
            
             Utility::Redirect(BASE_REF . "/account/order/check.php?id={$flag}");
            
             } 
        
        
        
        } else { // Regular Deal
        
        
        
        $_POST['isgift'] = (isset($_POST['isgift']) && abs(intval($INI['display']['giftdeal']))) ? 'Yes' : 'No';
        
         if ($_POST['isgift'] == 'Yes') {
            
            if (!$_POST['giftemail'] or !$_POST['giftname']) {
                
                Session::Set('error', TEXT_EN_GIFT_CANNOT_BE_BLANK_EN);
                
                 Utility::Redirect(BASE_REF . "/manage/deals/buy.php?id={$deals['id']}&gift=Yes");
                
                 } 
            
            } else {
            
            $_POST['giftemail'] = '';
            
             $_POST['giftname'] = '';
            
             $_POST['giftmsg'] = '';
            
             } 
        
        
        
        $table->user_id = $login_user_id;
        
         $table->deals_id = $deals['id'];
        
         $table->city_id = $deals['city_id'];
        
         $table->fare = $deals['fare'];
        
         $table->express = 'N';
        
         $table->create_time = time();
        
         $table->credit = 0;
        
         $table->isgift = $_POST['isgift'];
        
         $table->giftemail = $_POST['giftemail'];
        
         $table->giftname = $_POST['giftname'];
        
         $table->giftmsg = $_POST['giftmsg'];
        
         $table->origin = ($table->quantity * $deals['deals_price']) + ($deals['delivery'] == 'express' ? $deals['fare'] : 0);
        
         $table->price = ($table->quantity * $deals['deals_price']) + ($deals['delivery'] == 'express' ? $deals['fare'] : 0);
        
		 $table->admin_id=1;
        
        
        
/**
         * * Added the patch for Deal Options : START *
         */
         $table->option_id = 0;
         $table->option_price = 0;
         $table->option_title = '';
        
         if ($_POST["payment_type"] == 'option') {
            $strSelectedOptionID = explode("_", $_POST['frm_options']);
             $strOptID = $strSelectedOptionID[0];
             $strOptPri = $strSelectedOptionID[1];
            
             $strOptions = Table::Fetch('options', $strOptID);
            
            
            
             $table->option_id = $strOptID;
             $table->option_price = $strOptPri;
             $table->option_title = $strOptions['title'];
            
             $table->origin = ($table->quantity * $strOptPri) + ($deals['delivery'] == 'express' ? $deals['fare'] : 0);
             $table->price = ($table->quantity * $strOptPri) + ($deals['delivery'] == 'express' ? $deals['fare'] : 0);
             } 
        
/**
         * * Added the patch for Deal Options : START *
         */
        
        $insert = array(
            
            'user_id', 'deals_id', 'city_id', 'state',
            
             'fare', 'express', 'origin',
            
             'address', 'zipcode', 'realname', 'mobile', 'quantity',
            
             'create_time', 'price', 'isgift', 'giftemail', 'giftname', 'giftmsg', 'option_id', 'option_price', 'option_title',
            
            );
        
         // $flag = $table->update($insert);
        
        
        if ($flag = $table->update($insert)) {
            
            if ($table->id) Utility::Redirect(BASE_REF . "/account/order/check.php?id={$table->id}");
            
             Utility::Redirect(BASE_REF . "/account/order/check.php?id={$flag}");
            
             } 
        
        
        
        } 
    
    } 

$ex_con = array(
    
    'user_id' => $login_user_id,
    
     'deals_id' => $deals['id'],
    
    );

$order = DB::LimitQuery('order', array(
        
        'condition' => $ex_con,
        
         'one' => true,
        
        ));

$partner = Table::Fetch('partner', $deals['partner_id']);

$category = Table::Fetch('category', $deals['product']);

$category_name = (is_array($category))?$category['name']:$category;

// each user per day per buy
if (!$order || abs(intval($INI['system']['multipurchase']))) {
    
    $order = array();
    
     $order['quantity'] = 1;
    
    } else {
    
    if ($order['state'] != 'unpay') {
        
        Session::Set('error', TEXT_EN_ONLY_ONE_DEAL_CAN_BE_PURCHASED_PER_PERSON_EN);
        
         Utility::Redirect(BASE_REF . '/index.php');
        
         } 
    
    } 

// end;

/**
 * * Added the patch for Deal Options : START *
 */
 $strOptionID = $_GET['opt'];

 if ($strOptionID) {
    $strOptionsDetails = Table::Fetch('options', $strOptionID);
    
     if ($strOptionsDetails) {
        $strcondition = " deals_id= '" . $id . "'";
         $strOptions = DB::LimitQuery('options', array(
                'condition' => $strcondition,
                 'order' => 'ORDER BY id ASC',
                ));
         for($k = 0;$k < count($strOptions);$k++) {
            $strOptions[$k]['strOptionTitle'] = substr($strOptions[$k]['title'], 0, 60);
             if ($strOptionID == $strOptions[$k]['id']) {
                $strPrice = $strOptions[$k]['options_price'];
                 } 
            } 
        } else {
        Utility::Redirect(BASE_REF . '/index.php');
         } 
    } 

if ($strOptionsDetails) {
    $order['origin'] = ($order['quantity'] * $strOptionsDetails['options_price']) + ($deals['delivery'] == 'express' ? $deals['fare'] : 0);
    } else {
    $order['origin'] = ($order['quantity'] * $deals['deals_price']) + ($deals['delivery'] == 'express' ? $deals['fare'] : 0);
    } 
/**
 * * Added the patch for Deal Options : END *
 */

// $order['origin'] = ($order['quantity'] * $deals['deals_price']) + ($deals['delivery']=='express' ? $deals['fare'] : 0);
$order['isgift'] = isset($_GET['gift']) ? $_GET['gift'] : $order['isgift'];

include template('deals_buy');

