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

class ZPartner

 {
    
    const SECRET_KEY = '@4!@#$%@';
    
    
    
     static public function GenPassword($p)
    {
        
         return md5($p . self::SECRET_KEY);
        
         } 
    
    
    
    static public function Create($partner_row)
    {
        
         } 
    
    
    
    static public function GetPartner($partner_id)
    {
        
         if (!$partner_id) return array();
        
         return Table::Fetch('partner', $partner_id);
        
         } 
    
    
    
    static public function GetAgentLogin($username, $password, $en = true)
    {
        
         if ($en) $password = self::GenPassword($password);
        
         return DB::GetTableRow('agent', array(
                
                'agentname' => $username,
                
                 'password' => $password,
                
                ));
        
         } 
    
    
    
    static public function GetLogin($username, $password, $en = true)
    {
        
         if ($en) $password = self::GenPassword($password);
        
         return DB::GetTableRow('partner', array(
                
                'username' => $username,
                
                 'password' => $password,
                
                ));
        
         } 
    
    
    
    static public function AgentLogin($username, $password, $en = true)
    {
        
         if ($en) $password = self::GenPassword($password);
        
         return DB::GetTableRow('agent', array(
                
                'agentname' => $username,
                
                 'password' => $password,
                
                ));
        
         } 
    
    
    
    static public function GetLoginPartner()
    {
        
         if (isset($_SESSION['partner_id'])) {
            
            return self::GetPartner($_SESSION['partner_id']);
            
             } 
        
        return array();
        
         } 
    
    
    
    static public function Login($partner_id)
    {
        
         Session::Set('partner_id', $partner_id);
        
         } 
    
    } 

