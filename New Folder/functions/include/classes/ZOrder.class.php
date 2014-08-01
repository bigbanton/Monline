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

class ZOrder {
    
    static public function CashIt($order)
    {
        
         global $login_user_id;
        
         if (! $order['state'] == 'pay') return 0;
        
        
        
         // update user money;
        $user = Table::Fetch('user', $order['user_id']);
        
         Table::UpdateCache('user', $order['user_id'], array(
                
                'money' => moneyit($user['money'] - $order['credit']),
                
                ));
        
        
        
         // update order
        Table::UpdateCache('order', $order['id'], array(
                
                'state' => 'pay',
                
                 'service' => 'cash',
                
                 'admin_id' => $login_user_id,
                
                 'money' => $order['origin'],
                
                ));
        
        
        
         $order = Table::FetchForce('order', $order['id']);
        
         Zdeals::BuyOne($order);
        
         } 
    
    
    
    static public function CreateFromCharge($money, $user_id, $time, $service)
    {
        
         if (!$money || !$user_id || !$time || !$service) return 0;
        
         $pay_id = "charge-{$user_id}-{$time}";
        
         $oarray = array(
            
            'user_id' => $user_id,
            
             'pay_id' => $pay_id,
            
             'service' => $service,
            
             'state' => 'pay',
            
             'money' => $money,
            
             'origin' => $money,
            
             'create_time' => $time,
            
            );
        
         return DB::Insert('order', $oarray);
        
         } 
    
    } 

