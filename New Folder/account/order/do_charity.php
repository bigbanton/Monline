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

if ($charfor == 'PCharity')

 {
    
    // $pcharity = $pcharity + $amm;
    $percent = $INI['charity']['charopac'];
    
     $charid = 'charopa';
    
    
    
    } 

if ($charfor == 'OCharity')

 {
    
    // $ocharity = $ocharity + $amm;
    $percent = $INI['charity']['charopbc'];
    
     $charid = 'charopb';
    
    } 

if ($charfor == 'CCharity')

 {
    
    $percent = $INI['charity']['charopcc'];
    
     $charid = 'charopc';
    
    } 

if ($amm > 0)

 {
    
    $order = Table::FetchForce('order', $order_id);
    
    $condition = array(
        
        'charity_id' => $order['deals_id'] . '-' . $charid,
        
        );
    
    
    
     $charity = DB::LimitQuery('charity', array(
            
            'condition' => $condition,
            
            ));
    
    
    
     if (!$charity) {
        
        $ddonation = array(
            
            'charity_id' => $order['deals_id'] . '-' . $charid,
            
             'type' => $charid,
            
             'value' => ($amm * $percent) / 100,
            
            );
        
         DB::Insert('charity', $ddonation);
        
         } 
    
    else {
        
        $ddonation = ($amm * $percent) / 100;
        
         $ddonation = $charity['value'] + $ddonation;
        
         Table::UpdateCache('charity', $order['deals_id'] . '-' . $charid, array(
                
                'value' => $ddonation,
                
                ));
        
         } 
    
    } 

