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

need_partner();

$partner_id = abs(intval($_SESSION['partner_id']));

$action = strval($_GET['action']);

$id = $order_id = abs(intval($_GET['id']));

$deals = Table::Fetch('deals', $id);

need_auth($deals['partner_id'] == $partner_id);

if ('dealsdetail' == $action) {
    
    $partner = Table::Fetch('partner', $deals['partner_id']);
    
     $paycount = Table::Count('order', array(
            
            'state' => 'pay',
            
             'deals_id' => $id,
            
            ));
    
     $buycount = Table::Count('order', array(
            
            'state' => 'pay',
            
             'deals_id' => $id,
            
            ), 'quantity');
    
     $onlinepay = Table::Count('order', array(
            
            'state' => 'pay',
            
             'deals_id' => $id,
            
            ), 'money');
    
     $creditpay = Table::Count('order', array(
            
            'state' => 'pay',
            
             'deals_id' => $id,
            
            ), 'credit');
    
     $cardpay = Table::Count('order', array(
            
            'state' => 'pay',
            
             'deals_id' => $id,
            
            ), 'card');
    
     $couponcount = Table::Count('coupon', array(
            
            'deals_id' => $id,
            
            ));
    
     $deals['state'] = deals_state($deals);
    
     $html = render('manage_tsg_dialog_dealsdetail');
    
     json($html, 'dialog');
    
    } 

