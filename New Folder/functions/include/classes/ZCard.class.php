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

class ZCard

 {
    
    const ERR_NOCARD = -1;
    
     const ERR_deals = -2;
    
     const ERR_CREDIT = -3;
    
     const ERR_EXPIRE = -4;
    
     const ERR_USED = -5;
    
     const ERR_ORDER = -6;
     const ERR_REDEM = -7;
    
    
    
     static public function Explain($errno)
    {
        
         switch ($errno) {
        
        case self::ERR_NOCARD : return 'error1';
            
             case self::ERR_deals : return 'error2';
            
             case self::ERR_CREDIT : return 'error3';
            
             case self::ERR_EXPIRE : return 'error4';
            
             case self::ERR_USED : return 'error5';
            
             case self::ERR_ORDER: return 'error6';
            
             case self::ERR_REDEM : return 'dealerror';
            
             } 
        
        return 'Unknown error';
        
         } 
    
    
    
    static public function UseCard($order, $card_id)
    
    
    {
        
         if ($order['card_id']) return self::ERR_ORDER;
        
         $card = Table::Fetch('card', $card_id);
        
         if (!$card) return self::ERR_NOCARD;
        
         if ($card['consume'] == 'Y') return self::ERR_USED;
        
         $today = strtotime(date('Y-m-d'));
        
         if ($card['begin_time'] > $today
            
             || $card['end_time'] < $today) return self::ERR_EXPIRE;
        
        
        
         $deals = Table::Fetch('deals', $order['deals_id']);
        
         if ($card['partner_id'] > 0
            
             && $card['partner_id'] != $deals['partner_id']) {
            
            return self::ERR_deals;
            
             } 
        
        
        if ($order['origin'] < $card['credit']) return self::ERR_REDEM;
        
         if ($deals['card'] < $card['credit']) return self::ERR_CREDIT;
        
         $finalcard = ($card['credit'] > $order['origin']) ? $order['origin'] : $card['credit'];
        
        
        
        
         Table::UpdateCache('order', $order['id'], array(
                
                'card_id' => $card_id,
                
                 'card' => $finalcard,
                
                 'origin' => array("origin - {$finalcard}"),
                
                ));
        
         Table::UpdateCache('card', $card_id, array(
                
                'consume' => 'Y',
                
                 'deals_id' => $deals['id'],
                
                 'order_id' => $order['id'],
                
                 'ip' => Utility::GetRemoteIp(),
                
                ));
        
         return true;
        
         } 
    
    
    
    static public function CardCreate($query)
    
    
    {
        
         $need = $query['quantity'];
        
         $flag = false;
        
         while ($flag == false) {
            
            $id = Utility::GenSecret(16, Utility::CHAR_NUM);
            
             $card = array(
                
                'id' => $id,
                
                 'code' => $query['code'],
                
                 'partner_id' => $query['partner_id'],
                
                 'credit' => $query['money'],
                
                 'consume' => 'N',
                
                 'begin_time' => $query['begin_time'],
                
                 'end_time' => $query['end_time'],
                
                );
            
             $need -= (DB::Insert('card', $card)) ? 1 : 0;
            
             if ($need <= 0) $flag = true;
            
             } 
        
        
        
        // ACTIVITY LOG
        ZLog::Log(0, 'Discount Vouchers Created', 'Quantity:' . $query['quantity'] . ', Code:' . $query['code'] . '. Discount vouchers are different than deal coupons');
        
         // ACTIVITY LOG
        
        
        return true;
        
         } 
    
    } 

