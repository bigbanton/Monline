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
$module = 'financials';
$memail = strval($_GET['memail']);

$oemail = strval($_GET['oemail']);

($s = strtolower(strval($_GET['s']))) || ($s = 'index');

if (!$s || !in_array($s, array('index', 'record'))) $s = 'index';

$condition = array('credit > 0', 'pay' => 'N',);

if ('record' == $s) $condition['pay'] = 'Y';

if ($memail) {
    
    $muser = Table::Fetch('user', $memail, 'email');
    
     if ($muser) $condition['user_id'] = $muser['id'];
    
    } 

if ($oemail) {
    
    $ouser = Table::Fetch('user', $oemail, 'email');
    
     if ($ouser) $condition['other_user_id'] = $ouser['id'];
    
    } 

$count = Table::Count('invite', $condition);

$summary = Table::Count('invite', $condition, 'credit');

list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$invites = DB::LimitQuery('invite', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

$deals_ids = Utility::GetColumn($invites, 'deals_id');

$deals = Table::Fetch('deals', $deals_ids);

$user_ids = Utility::GetColumn($invites, 'user_id');

$user_ido = Utility::GetColumn($invites, 'other_user_id');

$admin_ids = Utility::GetColumn($invites, 'admin_id');

$user_ids = array_merge($user_ids, $user_ido, $admin_ids);

$users = Table::Fetch('user', $user_ids);

include template('manage_finance_invite');

