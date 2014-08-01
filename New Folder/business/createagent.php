<?php

ob_start();

// require_once($_SERVER['DOCUMENT_ROOT'] . '/app.php');
require_once(dirname(dirname(__FILE__)) . '/app.php');
$ob_content = ob_get_clean();

need_partner(true);

$partner_id = abs(intval($_SESSION['partner_id']));

$login_partner = Table::Fetch('partner', $partner_id);

if ($_POST) {
    
    $flag = 0;
    
     if (strlen($_POST["password"]) < 5) {
        
        Session::Set('error', 'Password must be greater than 5 characters');
        
         $flag = 1;
        
         } 
    
    
    
    if ($_POST["password"] != $_POST["confirmpassword"]) {
        
        Session::Set('error', 'Password is mis-match. Please re-enter');
        
         $flag = 1;
        
         } 
    
    
    
    $condition = "agentname = '" . $_POST["agentname"] . "' and partnerid = '" . $partner_id . "' ";
    
     $count = Table::Count('agent', $condition);
    
    
    
     if ($count == 0) {
        
        if ($flag == 0) {
            
            $table = new Table('agent', $_POST);
            
             $table->create_time = time();
            
             $table->partnerid = $partner_id;
            
             $table->password = ZPartner::GenPassword($table->password);
            
             $table->insert(array(
                    
                    'partnerid', 'agentname', 'password', 'bank_name', 'create_time'
                    
                    ));
            
            
            
             // ACTIVITY LOG
            ZLog::Log(0, 'Agent Added', 'New agent (' . $_POST["agentname"] . ') added by Partner ID:' . $partner_id);
            
             // ACTIVITY LOG
            
            
            Session::Set('notice', 'Agent details added successfully.');
            
             Utility::Redirect(BASE_REF . '/business/agent.php');
            
             } else {
            
            $agentname = $_POST["agentname"];
            
             } 
        
        } else {
        
        $agentname = $_POST["agentname"];
        
         Session::Set('error', 'Your agent name is already exists.');
        
         } 
    
    
    
    } 

include template('create_agent');
