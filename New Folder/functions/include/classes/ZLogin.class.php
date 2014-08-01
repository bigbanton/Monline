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

class ZLogin

 {
    
    static public $cookie_name = 'griprus';
    
    
    
     static public function GetLoginId()
    {
        
         $user_id = abs(intval(Session::Get('user_id')));
        
         if (!$user_id) {
            
            $u = ZUser::GetLoginCookie(self::$cookie_name);
            
             $user_id = abs(intval($u['id']));
            
             } 
        
        if ($user_id) {
            
            self::Login($user_id);
            
             } else {
            
            Session::Set('grip_user_agent', $_SERVER['HTTP_USER_AGENT']);
            
             Session::Set('grip_user_ip', getRealIpAdd());
            
             } 
        
        
        
        return $user_id;
        
         } 
    
    
    
    static public function Login($user_id)
    {
        
         Session::Set('user_id', $user_id);
        
         Session::Set('grip_user_agent', $_SERVER['HTTP_USER_AGENT']);
        
         Session::Set('grip_user_ip', getRealIpAdd());
        
         return true;
        
         } 
    
    
    
    static public function NeedLogin()
    {
        
         $user_id = self::GetLoginId();
        
         return $user_id ? $user_id : false;
        
         } 
    
    
    
    static public function Remember($user)
    {
        
         $zone = "{$user['id']}@{$user['password']}";
        
         cookieset(self::$cookie_name, base64_encode($zone), 30 * 86400);
        
         } 
    
    
    
    static public function NoRemember()
    {
        
         cookieset(self::$cookie_name, null, -1);
        
         } 
    
    
    
    static public function ForceLogout()
    {
        
         unset($_SESSION['user_id']);
        
         unset($_SESSION['adbypass']);
        
         unset($_SESSION['FBCONNECT_LOGOUT_URL']);
        
         unset($_SESSION['grip_user_agent']);
        
         unset($_SESSION['grip_user_ip']);
        
         unset($_SESSION['last_login']);
        
         ZLogin::NoRemember();
        
        
        
         } 
    
    
    
    static public function CheckUserSession()
    {
        
         if ((!ZUser::GetLoginCookie(self::$cookie_name)) && ($_SERVER['HTTP_USER_AGENT'] !== Session::Get('grip_user_agent') || self::UserIPAdd() !== Session::Get('grip_user_ip'))) {
            
            self::ForceLogout();
            
             } 
        
        } 
    
    
    
    static public function UserIPAdd()
    
    
    {
        
         if (!empty($_SERVER['HTTP_CLIENT_IP'])) { // check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            
             } 
        
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            
             } 
        
        else
            
             {
            
            $ip = $_SERVER['REMOTE_ADDR'];
            
             } 
        
        return $ip;
        
         } 
    
    } 

