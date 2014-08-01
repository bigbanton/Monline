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

// error_reporting(E_ALL);
need_dealer();
$module='insta';
$ob_content = ob_get_clean();

if (is_partner()) {
    
    $partner_id = abs(intval($_SESSION['partner_id']));
    
    $login_partner = Table::Fetch('partner', $partner_id);
    
    } 

$langcondition = array('deleted' => '0', 'status' => 'enabled');

$languages = DB::LimitQuery('language', array(
        
        'condition' => $langcondition,
        
         'order' => 'ORDER BY id ASC',
        
        ));
 $deals1['begin_time'] = strtotime('+0 days');
 $deals1['end_time'] = strtotime('+5 days');

if ($_POST) {
    $deals1['begin_time'] = $_POST['begin_time'];
     $deals1['end_time'] = $_POST['end_time'];
    
     $deals = $_POST;
    
    
     $strError = 0;
    
    
    
     if (is_manager()) {
        
        if (empty($_POST['commission']) && !is_numeric($_POST['commission']) || $_POST['commission'] < 0 || $_POST['commission'] > 100) { // to validate the commission value
            
            $strError = 1;
            
             Session::Set('error', 'Please enter the valid commission value');
            
             } 
        
        } 
    
    
    
    if ($strError == 0) {
        
        
        
        $insert = array(
            
            'name', 'title', 'stage', 'market_price', 'deals_price', 'expire_time', 'end_time', 'begin_time', 'per_number',
            
             'product', 'image', 'user_id', 'city_id', 'partner_id', 'commission', 'lat', 'lng', 'address', 'zipcode', 'notice'
            
            );
        
        
        
         $deals['user_id'] = $login_user_id;
        
         $deals['begin_time'] = strtotime($deals['begin_time']);
        
         $deals['city_id'] = abs(intval($deals['city_id'])); // echo $deals['end_time'] . ' XX ';
        
        
         $deals['end_time'] = strtotime($deals['end_time']);
        
         // echo $deals['end_time'] ."/n"; echo "time == " . date('l dS \o\f F Y h:i:s A', $deals['end_time']); echo"/n/n". "Not allowed in the demo"; exit;
        $deals['expire_time'] = strtotime($deals['end_time']);
        
         $deals['image'] = upload_image('upload_image', null, 'deals');
        
         $_POST['notice'] = $deals['notice'] = $_POST['noticeen'];
        
         $_POST['title'] = $deals['title'] = $_POST['titleen'];
         $_POST['expire_time'] = $deals['end_time'];
        
        
         $table = new Table('insta', $deals);
        
         $table->SetStrip('notice', 'product', 'title');
        
        
        
         if ($deals_id = $table->insert($insert)) {
            
            if ($doit && abs(intval($INI['system']['dealalert'])) == 2 && ($_POST['stage'] == '1-featured' || $_POST['stage'] == 'approved')) {
                
                $indcall = 1;
                
                 $id = $deals_id;
                
                 $action = 'noticesubscribe';
                
                 $nid = 0;
                
                 $allow_flag = 'f8WE45Y^';
                
                 require_once(dirname(dirname(dirname(__FILE__))) . '/functions/ajax/asmailer.php');
                
                 // echo ' ...Yes';
                } 
            
            
            
            foreach ($languages as $language) {
                
                $details = array('deal_id', 'lang_id', 'title', 'notice');
                
                
                
                 $deal_details['deal_id'] = $deals_id;
                
                 $deal_details['lang_id'] = $language['id'];
                
                 $deal_details['title'] = ($deals['title' . $language['code']]) ? $deals['title' . $language['code']] : $deals['titleen'];
                
                 // $deal_details['summary'] = ($deals['summary'.$language['code']]) ? $deals['summary'.$language['code']] : $deals['summaryen'];
                $deal_details['notice'] = ($deals['notice' . $language['code']]) ? $deals['notice' . $language['code']] : $deals['noticeen'];
                
                 // $deal_details['detail'] = ($deals['detail'.$language['code']]) ? $deals['detail'.$language['code']] : $deals['detailen'];
                // $deal_details['userreview'] = ($deals['userreview'.$language['code']]) ? $deals['userreview'.$language['code']] : $deals['userreviewen'];
                
                
                $detailstable = new Table('insta_details', $deal_details);
                
                 $detailstable->SetStrip('notice', 'title');
                
                 $detailstable->insert($details);
                
                 } 
            
            
            
            // ACTIVITY LOG
            ZLog::Log($login_user_id, 'Deal Added', 'Deal Type:Insta, Deal ID:' . $deals_id);
            
             // ACTIVITY LOG
            
            
            // echo ' ...No';
            Utility::Redirect(BASE_REF . "/manage/insta/index.php");
            
             } 
        
        else {
            
            echo "Error ";
            
             exit;
            
             } 
        
        } 
    
    
    
    
    
    
    
    } 

else {
    
    $profile = Table::Fetch('leader', $login_user_id, 'user_id');
    
     // 1
    $deals = array();
    
     $deals['user_id'] = $login_user_id;
    
     $deals['begin_time'] = strtotime('+1 days');
    
     $deals['end_time'] = strtotime('+2 days');
    
     $deals['expire_time'] = strtotime('+3 months +1 days');
    
     $deals['min_number'] = 10;
    
     $deals['per_number'] = 1;
    
     $deals['market_price'] = 1;
    
     $deals['deals_price'] = 1;
    
     // 3
    $deals['delivery'] = 'coupon';
    
     $deals['address'] = $profile['address'];
    
     $deals['mobile'] = $profile['mobile'];
    
     $deals['fare'] = 5;
    
     $deals['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
    
    } 

$groups = DB::LimitQuery('category', array(
        
        'condition' => array(),
        
        ));

$groups = Utility::OptionArray($groups, 'id', 'name');

if (is_partner()) {
    
    $condition = array(
        
        'id' => $partner_id,
        
        );
    
    $partners = DB::LimitQuery('partner', array(
            
            'condition' => $condition,
            
            ));
    
    } else {
    
    $partners = DB::LimitQuery('partner', array(
            
            'order' => 'ORDER BY id DESC',
            
            ));
    
    
    
    $partners = Utility::OptionArray($partners, 'id', 'title');
    
    } 

$selector = 'create';

$bizstageoptions = array(
    
    'draft' => 'Save as Draft',
    
     'pending' => 'Submit for Approval',
    
    );

$adminstageoptions = array(
    
    
    
    'draft' => 'Draft',
    
    
    
     'pending' => 'Pending',
    
    
    
     'returned' => 'Returned',
    
    
    
     'canceled' => 'Canceled',
    
    
    
     'approved' => 'Approved',
    
    
    
     // '1-featured' => 'Approved + Featured Deal',
    
    
    );

if (is_partner()) {
    
    include template('business_insta_create');
    
    } 

else {
    
    include template('manage_insta_create');
    
    } 
