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

need_dealer();
$module='insta';
$id = abs(intval($_GET['id']));

if (!$id || !$deals = Table::Fetch('insta', $id)) {
    
    
    
    Utility::Redirect(BASE_REF . '/manage/insta/create.php');
    
    
    
    } 

$deal_details = DB::LimitQuery('insta_details', array('condition' => array('deal_id' => $id,),));

$action = $_GET['action']; //Get defined action

$image = $_GET['image']; //Action on the product image

if ($action == 'remove' && $image) {
    
    
    
    $imgpath = $deals['image' . $image];
    
    
    
     if ($deals['image2'] && $image < 2) { // Move image up
        
        
        
        $deals['image1'] = $deals['image2'];
        
        
        
         $image = 2;
        
        
        
         } 
    
    
    
    $deals['image' . $image] = '';
    
    
    
    Table::UpdateCache('insta', $deals['id'], array(
            
            
            
            'image1' => $deals['image1'],
            
            
            
             'image2' => $deals['image2'],
            
            
            
            ));
    
    
    
    
    
    
    
    $deleteimg = remove_prod_image(DIR_BACKEND . '/themes/deals/' . $imgpath);
    
    
    
    
    
    
    
     if ($deleteimg) Session::Set('notice', TEXT_EN_PRODUCT_IMAGE_HAS_BEEN_REMOVED_EN);
    
    
    
     Utility::Redirect(BASE_REF . "/manage/insta/edit.php?id={$deals['id']}");
    
    
    
    } 

$langcondition = array('deleted' => '0', 'status' => 'enabled');

$languages = DB::LimitQuery('language', array(
        
        'condition' => $langcondition,
        
         'order' => 'ORDER BY id ASC',
        
        ));

$deals1['begin_time'] = $deals['begin_time'];
 $deals1['end_time'] = $deals['end_time'];

if ($_POST) {
    $deals1['begin_time'] = $_POST['begin_time'];
     $deals1['end_time'] = $_POST['end_time'];
    
    
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
        
        
        
        
        
         if ($_POST['stage'] == 'draft' || $_POST['stage'] == 'pending' || $_POST['stage'] == 'returned' || $_POST['stage'] == 'canceled') { // can not edit commission if the deal is approved
            
            
            
            // print "level-1";
            
            
            if (($_POST['system'] == 'Y' && strtotime($_POST['end_time']) < time() && $_POST['now_number'] < $_POST['min_number']) || ($_POST['system'] == 'Y' && strtotime($_POST['end_time']) < time() && $_POST['now_number'] >= $_POST['min_number'])) { // if the deal is tipped or failed cant edit commission
                
                
                
                // do nothing in insert array
                
                
                // print "level-2";
                
                
                } else {
                
                
                
                // print "level-3";
                
                
                array_push($insert, 'commission');
                
                
                
                 } 
            
            
            
            } 
        
        
        
        
        
        
        
        
        
        
        
        $table = new Table('insta', $_POST);
        
        
        
         $table->SetStrip('notice', 'product', 'title');
        
         $table->expire_time = strtotime($_POST['end_time']);
        
         $table->begin_time = strtotime($_POST['begin_time']);
        
         $table->title = $_POST['titleen'];
        
         $table->end_time = strtotime($_POST['end_time']);
        
        
         $table->image = upload_image('upload_image', $deals['image'], 'deals');
        
        
         $error_tip = array();
        
        
        
         if (!$error_tip) {
            
            
            
            if ($table->update($insert)) {
                
                
                
                if (abs(intval($INI['system']['dealalert'])) == 2 && ($_POST["stage"] == '1-featured' || $_POST["stage"] == 'approved')) {
                    
                    $indcall = 1;
                    
                     $id = $deals_id;
                    
                     $action = 'noticesubscribe';
                    
                     $nid = 0;
                    
                     $allow_flag = 'f8WE45Y^';
                    
                     require_once(dirname(dirname(dirname(__FILE__))) . '/functions/ajax/asmailer.php');
                    
                     } 
                
                
                
                $details = array('deal_id', 'lang_id', 'title', 'notice');
                
                
                
                 foreach ($languages as $language) {
                    
                    $_POST['deal_id'] = $deals['id'];
                    
                     $_POST['lang_id'] = $language['id'];
                    
                     $_POST['title'] = $_POST['title' . $language['code']];
                    
                     $_POST['notice'] = $_POST['notice' . $language['code']];
                    
                    
                    
                     if ($dealid = DB::LimitQuery('insta_details', array(
                                
                                'condition' => array('deal_id' => $deals['id'], 'lang_id' => $language['id']),
                                    
                                    ))) {
                        
                        $detailstable = new Table('insta_details', $_POST);
                        
                         $detailstable->SetStrip('notice', 'title');
                        
                         $detailstable->SetPk('id', $dealid[0]['id']);
                        
                         $array = array('title' => stripslashes($deal_details['title']),
                            
                             'notice' => stripslashes($deal_details['notice']),
                            
                            );
                        
                         $detailstable->update($details);
                        
                         } else {
                        
                        
                        
                        $deal_create['deal_id'] = $deals_id;
                        
                         $deal_create['lang_id'] = $language['id'];
                        
                         $deal_create['title'] = ($deals['title' . $language['code']]) ? $deals['title' . $language['code']] : $deals['titleen'];
                        
                         $deal_create['notice'] = ($deals['notice' . $language['code']]) ? $deals['notice' . $language['code']] : $deals['noticeen'];
                        
                        
                        
                         $createtable = new Table('insta_details', $_POST);
                        
                         $createtable->SetStrip('notice', 'title');
                        
                         $createtable->insert($details);
                        
                        
                        
                         } 
                    
                    } 
                
                
                
                // ACTIVITY LOG
                global $login_user_id;
                
                 ZLog::Log($login_user_id, 'Deal Updated', 'Deal Type:Insta, Deal ID:' . $deals['id']);
                
                 // ACTIVITY LOG
                
                
                Utility::Redirect(BASE_REF . "/manage/insta/edit.php?id={$deals['id']}");
                
                
                
                 } else {
                
                
                
                Session::Set('error', TEXT_EN_MODIFY_DEALS_INFORMATION_FAILED_CHECK_YOUR_SYSTEM_SETTING_PLEASE_EN);
                
                
                
                 } 
            
            
            
            } 
        
        
        
        
        
        
        
        } 
    
    
    
    
    
    
    
    
    
    
    
    } 

$groups = DB::LimitQuery('category', array(
        
        'condition' => array(),
        
        ));

$groups = Utility::OptionArray($groups, 'id', 'name');

$partners = DB::LimitQuery('partner', array(
        
        
        
        'order' => 'ORDER BY id DESC',
        
        
        
        ));

$partners = Utility::OptionArray($partners, 'id', 'title');

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
    
    
    
    if ($deals['stage'] == 'approved') {
        
        
        
        Utility::Redirect(BASE_REF . '/manage/insta/index.php');
        
        
        
         } 
    
    
    
    include template('business_insta_edit');
    
    
    
    } 

else {
    
    
    
    include template('manage_insta_edit');
    
    
    
    } 
