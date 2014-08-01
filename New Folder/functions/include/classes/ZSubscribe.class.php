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

class ZSubscribe

 {
    
    static public function Create($email, $city_id)
    
    
    {
        
         if (!Utility::ValidEmail($email, true)) return;
        
         $secret = md5($email . $city_id);
        
         $table = new Table('subscribe', array(
                
                'email' => $email,
                
                 'city_id' => $city_id,
                
                 'secret' => $secret,
                
                ));
        
         Table::Delete('subscribe', $email, 'email');
        
         $table->insert(array('email', 'city_id', 'secret'));
        
        
        
         // ACTIVITY LOG
        global $login_user_id;
        
         ZLog::Log($login_user_id, 'Email Subscribed', 'Email: ' . $email . ', City ID:' . $city_id);
        
         // ACTIVITY LOG
        } 
    
    
    
    static public function Unsubscribe($subscribe)
    {
        
         Table::Delete('subscribe', $subscribe['email'], 'email');
        
        
        
         // ACTIVITY LOG
        global $login_user_id;
        
         ZLog::Log($login_user_id, 'Email Unsubscribed', 'Alert >> Email: ' . $subscribe['email'] . ', City ID:' . $subscribe['city_id']);
        
         // ACTIVITY LOG
        } 
    
    } 

