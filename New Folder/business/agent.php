<?php

ob_start();

// require_once($_SERVER['DOCUMENT_ROOT'] . '/app.php');
require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();

need_partner(true);

$partner_id = abs(intval($_SESSION['partner_id']));

$login_partner = Table::Fetch('partner', $partner_id);

$condition = array(
    
    'partnerid' => $partner_id,
    
    );

$count = Table::Count('agent', $condition);

list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$agents = DB::LimitQuery('agent', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

include template('manage_agent');
