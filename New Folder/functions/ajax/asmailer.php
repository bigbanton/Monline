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

$indcall = $indcall ? $indcall : $_POST['indcall'];

if (!$indcall) {
    
    ob_start();
    
    require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
    
    $ob_content = ob_get_clean();
    
    } 

$action = $action ? $action : strval($_POST['action']);

$id = $id ? $id : abs(intval($_POST['id']));

if (!$allow_flag) $allow_flag = abs(intval($INI['system']['dealalert'])) ? $mydef_key : $_POST['key'];

if ($allow_flag != $mydef_key || !abs(intval($INI['system']['dealalert']))) {
    
    echo 'Either options to send auto subcription emails is turned off or you are not authorized to access this module. Command Failed.';
    
    exit();
    
    } 

$daytime = time();

if ('noticesubscribe' == $action) {
    
    $nid = $nid ? $nid : abs(intval($_POST['nid']));
    
     $now = time();
    
    
    
     if ($id) {
        
        $deals = Table::Fetch('deals', $id);
        
         $status[$id]['states'] = deals_state($deals);
        
        
        
         if ($status[$id]['states'] != 'soldout' && $deals["begin_time"] < $daytime && $deals["end_time"] > $daytime && ($deals['stage'] == 'approved' || $deals['stage'] == '1-featured')) {
            
            
            
            $partner = Table::Fetch('partner', $deals['partner_id']);
            
             $city = Table::Fetch('cities', $deals['city_id']);
            
            
            
             if ($deals['city_id'] > 0) {
                
                $condition = array('city_id' => $deals['city_id'],);
                
                 } 
            
            else {
                
                $condition = array('length("city_id") > 0',);
                
                 } 
            
            
            
            $subs = DB::LimitQuery('subscribe', array(
                    
                    'condition' => $condition,
                    
                     'order' => 'ORDER BY id ASC',
                    
                     'offset' => $nid,
                    
                     // 'size' => 1,
                    ));
            
            
            
            // echo 'Sending emails..<br><br';
            
            
             if ($subs) {
                
                foreach($subs AS $one) {
                    
                    $nid++;
                    
                     // echo $one['email'] . "<br>\n\n";
                    ob_start();
                    
                     if (abs(intval($INI['system']['dealalert'])) > 0) mail_subscribe($city, $deals, $partner, $one); //No spamming please
                    
                    
                     $v = ob_get_clean();
                    
                     // $cost = time() - $now;
                    } 
                
                } //end if subs
            
             Table::UpdateCache('deals', $id, array('sendalert' => '0'));
            
             } 
        
        
        
        
        
        } else {
        
        
        
        
        
        $condition = array(
            
            'sendalert' => 1,
            
             "begin_time < {$daytime}",
            
             "end_time > {$daytime}",
            
            );
        
        
        
         $subs = DB::LimitQuery('deals', array(
                
                'condition' => $condition,
                
                 'order' => 'ORDER BY id ASC',
                
                 // 'offset' => $nid,
                // 'size' => 1,
                ));
        
        
        
         foreach ($subs AS $deals) {
            
            // print_r($one);
            // echo $one['city_id'];
            
            
            $status[$id]['states'] = deals_state($deals);
            
            
            
             if ($status[$id]['states'] != 'soldout' && ($deals['stage'] == 'approved' || $deals['stage'] == '1-featured')) {
                
                
                
                $id = $deals['id'];
                
                 $partner = Table::Fetch('partner', $deals['partner_id']);
                
                 $city = Table::Fetch('cities', $deals['city_id']);
                
                
                
                 if ($deals['city_id'] > 0) {
                    
                    $condition = array('city_id' => $deals['city_id'],);
                    
                     } 
                
                else {
                    
                    $condition = array('length("city_id") > 0',);
                    
                     } 
                
                
                
                $subs = DB::LimitQuery('subscribe', array(
                        
                        'condition' => $condition,
                        
                         'order' => 'ORDER BY id ASC',
                        
                         'offset' => $nid,
                        
                         // 'size' => 1,
                        ));
                
                
                
                // echo 'Sending emails..<br><br';
                
                
                 if ($subs) {
                    
                    foreach($subs AS $one) {
                        
                        $nid++;
                        
                         // echo $one['email'] . "<br>\n\n";
                        ob_start();
                        
                         if (abs(intval($INI['system']['dealalert'])) > 0) mail_subscribe($city, $deals, $partner, $one); //No spamming please
                        
                        
                         $v = ob_get_clean();
                        
                         // $cost = time() - $now;
                        } 
                    
                    } 
                
                Table::UpdateCache('deals', $id, array('sendalert' => '0'));
                
                 } // end if condition	
            
             } //end foreach
        
         } //end if id
    
    } 

echo "Cron Completed successfully";

?>