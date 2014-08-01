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

$action = strval($_GET['action']);

$id = $topic_id = abs(intval($_GET['id']));

$topic = Table::Fetch('topic', $id);

$pid = abs(intval($topic['parent_id']));

if (!$topic || !$id) {
    
    json('Invalid topic', 'alert');
    
    } 

elseif ($action == 'topicremove') {
    
    if ($pid == 0) {
        
        Table::Delete('topic', $id);
        
         Table::Delete('topic', $id, 'parent_id');
        
         } else {
        
        Table::Delete('topic', $id);
        
         Table::UpdateCache('topic', $pid, array(
                
                'reply_number' => Table::Count('topic', array('parent_id' => $pid)),
                
                ));
        
         } 
    
    Session::Set('notice', TEXT_EN_DELETE_POST_OK_EN);
    
     json(null, 'refresh');
    
    } 

elseif ($action == 'topichead') {
    
    if ($topic['parent_id'] > 0) {
        
        json('Only a topic can be set to top', 'alert');
        
         } 
    
    $head = ($topic['head'] == 0) ? time() : 0;
    
     Table::UpdateCache('topic', $id, array('head' => $head,));
    
     $tip = $head ? 'Set to top OK' : 'Cancel top topic OK';
    
     Session::Set('notice', $tip);
    
     json(null, 'refresh');
    
    } 

