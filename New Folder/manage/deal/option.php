<?php

/**
 * //License information must not be removed.
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @arch ### Secured  ###
 * @author Development Team, Gripsell Tech 
 * @Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @license EULA License http://www.gripsell.com
 * @Version $Version: 5.3.3 $
 * @Last Revision $Date: 2013-21-05 00:00:00 +0530 (Tue, 21 May 2013) $
 */
ob_start();
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
$ob_content = ob_get_clean();
need_dealer();
$deals_id = abs(intval($_GET['id']));
if (!$deals_id || !$deals = Table::Fetch('deals', $deals_id)) {
    Utility::Redirect(BASE_REF . '/manage/deal/create.php');
    } 

if ($_POST) {
    $options = $_POST;
    
     if ($_POST["option_title"]) {
        $condition = " deals_id= '" . $deals_id . "'";
         DB::DelTableRow('options', $condition);
        
         $table = new Table('options', $_POST);
        
         for($k = 0;$k < count($_POST["option_title"]);$k++) {
            if ($_POST["option_title"][$k]) {
                $table->deals_id = $deals_id;
                 $table->title = $_POST["option_title"][$k];
                 $table->options_price = $_POST["options_price"][$k];
                 $table->insert(array(
                        'deals_id', 'title', 'options_price',
                        ));
                 } 
            } 
        Session::Set('notice', 'Options added successfully');
         Utility::Redirect(BASE_REF . "/manage/deal/option.php?id={$deals['id']}");
         } 
    } 

$strcondition = " deals_id= '" . $deals_id . "'";
$strOptions = DB::LimitQuery('options', array(
        'condition' => $strcondition,
         'order' => 'ORDER BY id ASC',
        ));

if (is_partner(true)) {
    include template('business_deals_option');
    } 
else {
    include template('manage_deals_option');
    } 
