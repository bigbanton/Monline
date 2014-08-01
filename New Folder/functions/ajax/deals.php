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

need_login();

$action = strval($_GET['action']);

$id = $deals_id = abs(intval($_GET['id']));

$deals = Table::Fetch('deals', $deals_id);

if ($action == 'remove' && $deals['user_id'] == $login_user_id) {
    
    DB::DelTableRow('deals', array('id' => $deals_id));
    
     json("jQuery('#deals-list-id-{$deals_id}').remove();", 'eval');
    
    } 

else if ($action == 'ask') {
    
    $content = trim($_POST['content']);
    
     if ($content) {
        
        $table = new Table('ask', $_POST);
        
         $table->SetStrip('content');
        
         $table->user_id = $login_user_id;
        
         $table->deals_id = $deals['id'];
        
         $table->city_id = $deals['city_id'];
        
         $table->create_time = time();
        
         $table->insert(array('user_id', 'deals_id', 'city_id', 'content', 'create_time'));
        
         } 
    
    json(0);
    
    } 

json(0);

?>

