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

$id = abs(intval($_GET['id']));

if (!$id || !$deals = Table::Fetch('deals', $id)) {
    
    Utility::Redirect(BASE_REF . '/manage/deals/index.php');
    
    } 

deals_state($deals);

$pagetitle = "{$INI['system']['abbreviation']} Ask and Answer {$deals['title']}";

$condition = array('deals_id > 0', 'length(comment)>0');

/**
 * pageit
 */

$count = Table::Count('ask', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$asks = DB::LimitQuery('ask', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

/**
 * endpage
 */

$user_ids = Utility::GetColumn($asks, 'user_id');

$users = Table::Fetch('user', $user_ids);

include template('deals_ask');

