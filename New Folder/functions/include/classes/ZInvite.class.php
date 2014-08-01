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

class ZInvite

 {
    
    static public function Create($ruser, $newuser)
    {
        
         if ($ruser['id'] == $newuser['id']) return;
        
         $invite = array(
            
            'user_id' => $ruser['id'],
            
             'user_ip' => $ruser['ip'],
            
             'other_user_id' => $newuser['id'],
            
             'other_user_ip' => $newuser['ip'],
            
             'create_time' => time(),
            
            );
        
         cookieset('_rid', null, -1);
        
        
        
         // ACTIVITY LOG
        ZLog::Log($ruser, 'Invite Rebate Extended', 'Rebate extended to User ID:' . $ruser . ' for inviting User ID:' . $newuser);
        
         // ACTIVITY LOG
        
        
        return DB::Insert('invite', $invite);
        
         } 
    
    
    
    static public function CreateFromId($user_id, $other_user_id)
    {
        
         if (!$user_id || !$other_user_id) return;
        
         if ($user_id == $other_user_id) return;
        
         $ruser = Table::Fetch('user', $user_id);
        
         $newuser = Table::Fetch('user', $other_user_id);
        
         if ($newuser['newbie'] == 'Y') {
            
            self::Create($ruser, $newuser);
            
             } 
        
        } 
    
    
    
    static public function CreateFromBuy($other_user_id)
    {
        
         $rid = abs(intval(cookieget('_rid')));
        
         return self::CreateFromId($rid, $other_user_id);
        
         } 
    
    
    
    static public function CheckInvite($order)
    {
        
         if ($order['state'] == 'unpay') return;
        
         global $INI;
        
         $invitecredit = abs(intval($INI['system']['invitecredit']));
        
         if (!$invitecredit) return;
        
         self::CreateFromBuy($order['user_id']);
        
         $user = Table::Fetch('user', $order['user_id']);
        
         if (!$user || $user['newbie'] != 'Y') return;
        
         $invite = Table::Fetch('invite', $order['user_id'], 'other_user_id');
        
         if (!$invite || $invite['credit'] > 0 || $invite['pay'] != 'N') return;
        
        
        
         Table::UpdateCache('invite', $invite['id'], array(
                
                'credit' => $invitecredit,
                
                 'deals_id' => $order['deals_id'],
                
                 'buy_time' => time(),
                
                ));
        
         Table::UpdateCache('user', $order['user_id'], array(
                
                'newbie' => 'N',
                
                ));
        
         return true;
        
         } 
    
    } 

