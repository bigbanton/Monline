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

class ZUser

 {
    
    const SECRET_KEY = '@4!@#$%@'; //Do not change
    
    
    
    
     static public function GenPassword($p)
    {
        
         return md5($p . self::SECRET_KEY);
        
         } 
    
    
    
    static public function Create($user_row)
    {
        
         $user_row['password'] = self::GenPassword($user_row['password']);
        
         $user_row['create_time'] = $user_row['login_time'] = time();
        
         $user_row['ip'] = Utility::GetRemoteIp();
        
         $user_row['secret'] = md5(Utility::GenSecret(12));
        
         $user_row['id'] = DB::Insert('user', $user_row);
        
         $_rid = abs(intval(cookieget('_rid')));
        
         if ($_rid) {
            
            $r_user = Table::Fetch('user', $_rid);
            
             if ($r_user) ZInvite::Create($r_user, $user_row);
            
             } 
        
        if ($user_row['id'] == 1) {
            
            Table::UpdateCache('user', $user_row['id'], array(
                    
                    'manager' => 'Y',
                    
                     'secret' => '',
                    
                     'type' => '1',
                    
                     'receive' => '1',
                    
                    ));
            
             } 
        
        
        
        // ACTIVITY LOG
        ZLog::Log($user_row['id'], 'Registration');
        
         // ACTIVITY LOG
        
        
        return $user_row['id'];
        
         } 
    
    
    
    static public function GetUser($user_id)
    {
        
         if (!$user_id) return array();
        
         return DB::GetTableRow('user', array('id' => $user_id));
        
         } 
    
    
    
    static public function GetLoginCookie($cname = 'ru')
    {
        
         $cv = cookieget($cname);
        
         if ($cv) {
            
            $zone = base64_decode($cv);
            
             $p = explode('@', $zone, 2);
            
             return DB::GetTableRow('user', array(
                    
                    'id' => $p[0],
                    
                     'password' => $p[1],
                    
                    ));
            
             } 
        
        return Array();
        
         } 
    
    
    
    static public function GetLogin($email, $password, $en = true)
    {
        
         if ($en) $password = self::GenPassword($password);
        
         // $field = strpos($email, '@') ? 'email' : 'username';
        return DB::GetTableRow('user', array(
                
                'email' => $email,
                
                 'password' => $password,
                
                ));
        
         } 
    
    } 

