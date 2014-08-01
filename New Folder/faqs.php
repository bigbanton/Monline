<?php
ob_start();
require_once(dirname(__FILE__) . '/app.php');
$ob_content = ob_get_clean();

$page = DB::GetTableRow('templates', array('lang_id' => $syslang['id'], 'page_id' => 'fn_faqs'));
include template('fn_faqs');
