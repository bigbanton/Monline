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

need_manager();

if ($_POST) {
    
    $table = new Table('templates', $_POST);
    
     $value = stripslashes($_POST['value']);
    
     $title = stripslashes($_POST['title']);
    
     $table->value = Utility::ExtraEncode(array(
            
            'value' => $value,
            
             'title' => $title,
            
            ));
    
     $table->SetStrip('value');
    
     if ($n) {
        
        $table->SetPk('id', $id);
        
         $table->update(array('id', 'value'));
        
         } else {
        
        $table->insert(array('id', 'value'));
        
         } 
    
    } 

include template('manage_market_promotion');

