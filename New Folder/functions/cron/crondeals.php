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

$condition = array(
    
    'end_time < ' . time(),
    
    );

$deals = DB::LimitQuery('deals', array('condition' => $condition));

foreach ($deals as $deal) {
    
    
    
    $condition = array(
        
        'state' => 'pay',
        
         'deals_id' => $deal['id'],
        
         'isinsta' => 0,
        
        ); //Only those who have paid
    
    
    
    
     $orders = DB::LimitQuery('order', array('condition' => $condition));
    
    
    
     foreach ($orders as $order) {
        
        // echo $id = $order['id'];
        // echo '<br/>';
        // $order = Table::Fetch('order', $id);
        $rid = 'credit'; //strtolower(strval($_GET['rid']));
        
        
         if ($rid == 'credit') {
            
            ZFlow::CreateFromRefund($order);
            
             echo 'Order Refunded - ' . $order['id'] . "<br/>\n";
            
             } else {
            
            Table::UpdateCache('order', $id, array('state' => 'unpay'));
            
             } 
        
        
/**
         * deals --
         */
        
        $deals = Table::Fetch('deals', $order['deals_id']);
        
         deals_state($deals);
        
         if ($deals['state'] != 'failure') {
            
            $minus = $deals['conduser'] == 'Y' ? $order['quantity'] :1;
            
             Table::UpdateCache('deals', $deals['id'], array(
                    
                    'now_number' => array("now_number - {$minus}",),
                    
                    ));
            
             } 
        
        
/**
         * card refund
         */
        
        if ($order['card_id']) {
            
            Table::UpdateCache('card', $order['card_id'], array(
                    
                    'consume' => 'N',
                    
                     'deals_id' => 0,
                    
                     'order_id' => 0,
                    
                    ));
            
             } 
        
        
/**
         * coupons
         */
        
        if (in_array($deals['delivery'], array('coupon', 'pickup'))) {
            
            $coupons = Table::Fetch('coupon', array($order['id']), 'order_id');
            
             foreach($coupons AS $one) {
                
                echo 'Coupon Deleted - ' . $one['id'] . "<br/>\n";
                
                 // Table::Delete('coupon', $one['id']);
                } 
            
            } 
        
        
        
        
/**
         * order update
         */
        
        Table::UpdateCache('order', $id, array(
                
                'card' => 0,
                
                 'card_id' => '',
                
                 'express_id' => 0,
                
                 'express_no' => '',
                
                ));
        
        
        
         } 
    
    } 

echo "Order Check for Regular Deals - Cron Completed successfully\n";

?>