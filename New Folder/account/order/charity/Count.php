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

function updateDonation($charfor, $amm)

{
    
    static $pcharity;
    
    static $ocharity;
    
    static $ccharity;
    
    
    
    if ($charfor == 'PCharity')
    
     {
        
        $pcharity = $pcharity + $amm;
        
        } 
    
    
    
    if ($charfor == 'OCharity')
    
     {
        
        $ocharity = $ocharity + $amm;
        
        } 
    
    
    
    if ($charfor == 'CCharity')
    
     {
        
        $ccharity = $ccharity + $amm;
        
        } 
    
    
    
    } 

function getDonations()

{
    
    
    
    $_ENV[
    
    } 

?>

