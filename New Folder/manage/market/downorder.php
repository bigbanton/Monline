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

if ($_POST) {
    
    $deals_id = abs(intval($_POST['deals_id']));
    
     $service = $_POST['service'];
    
     $state = $_POST['state'];
    
     if (!$deals_id || !$service || !$state) die('-ERR ERR_NO_DATA');
    
    
    
     $condition = array(
        
        'service' => $service,
        
         'state' => $state,
        
         'deals_id' => $deals_id,
        
        );
    
     $orders = DB::LimitQuery('order', array(
            
            'condition' => $condition,
            
             'order' => 'ORDER BY id DESC',
            
            ));
    
    
    
     if (!$orders) die('-ERR ERR_NO_DATA');
    
     $deals = Table::Fetch('deals', $deals_id);
    
     $name = 'order_' . date('Ymd');
    
     $kn = array(
        
        'pay_id' => 'Pay ID',
        
         'id' => 'ID',
        
         'service' => 'Payment',
        
         'price' => 'Price',
        
         'quantity' => 'Amount',
        
         'fare' => 'Fare',
        
         'origin' => 'Original',
        
         'money' => 'Paid',
        
         'credit' => 'Credit',
        
         'state' => 'Pay Status',
        
        );
    
    
    
     if ($deals['delivery'] == 'express') {
        
        $kn = array_merge($kn, array(
                
                'realanem' => 'Recipient',
                
                 'mobile' => 'Handphone',
                
                 'zipcode' => 'Postcode',
                
                 'address' => 'Address',
                
                ));
        
         } 
    
    $pay = array(
        
        'paypal' => 'Paypal',
        
         'alipay' => 'Alipay',
        
         'tenpay' => 'Tenpay',
        
         'chinabank' => 'Chinabank',
        
         'credit' => 'Credit',
        
         'cash' => 'Cash',
        
         '' => 'Other',
        
        );
    
     $state = array(
        
        'unpay' => 'Unpaid',
        
         'pay' => 'Paid',
        
        );
    
     $eorders = array();
    
     foreach($orders AS $one) {
        
        $one['fare'] = ($one['delivery'] == 'express') ? $one['fare'] : 0;
        
         $one['service'] = $pay[$one['service']];
        
         $one['price'] = $deals['market_price'];
        
         $one['state'] = $state[$one['state']];
        
         $eorders[] = $one;
        
         } 
    
    down_xls($eorders, $kn, $name);
    
    } 

include template('manage_market_downorder');

