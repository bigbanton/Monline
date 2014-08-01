<?php

 ob_start();

 require_once($_SERVER['DOCUMENT_ROOT'] . '/app.php');

 $ob_content = ob_get_clean();

 need_partner(true);

 $partner_id = abs(intval($_SESSION['partner_id']));

 $login_partner = Table::Fetch('partner', $partner_id);

 $agent_id = $_GET["id"];

 $condition1 = "partnerid = '" . $partner_id . "' and id ='" . $agent_id . "' ";

 $agentcount = Table::Count('agent', $condition1);

 if ($agentcount) {
    
    if ($_POST && $agent_id == $_POST['id']) {
        
        
        
        $flag = 0;
        
        
        
         if ($_POST["password"] != '') {
            
            if (strlen($_POST["password"]) < 5) {
                
                Session::Set('error', 'Password must be greater than 5 characters');
                
                 $flag = 1;
                
                 } 
            
            if ($_POST["password"] != $_POST["confirmpassword"]) {
                
                Session::Set('error', 'Password is mis-match. Please re-enter');
                
                 $flag = 1;
                
                 } 
            
            } 
        
        
        
        $condition = "agentname = '" . $_POST["agentname"] . "' and partnerid = '" . $partner_id . "' and id !='" . $agent_id . "' ";
        
         $count = Table::Count('agent', $condition);
        
        
        
         if ($flag == 0) {
            
            if ($count == 0) {
                
                $table = new Table('agent', $_POST);
                
                 $up_array = array(
                    
                    'agentname',
                    
                    );
                
                
                
                 if ($table->password) {
                    
                    $table->password = ZPartner::GenPassword($table->password);
                    
                     $up_array[] = 'password';
                    
                     } 
                
                $flag = $table->update($up_array);
                
                 if ($flag) {
                    
                    Session::Set('notice', 'Agent details update succesfully!');
                    
                     Utility::Redirect(WEB_ROOT . '/business/agent.php');
                    
                     } 
                
                } else {
                
                Session::Set('error', 'Your agent name is already exists.');
                
                 } 
            
            } 
        
        } 
    
    } else {
    
    Session::Set('error', 'Invalid input credentials.');
    
     Utility::Redirect(BASE_REF . '/business/agent.php');
    
     } 

$condition = array(
    
    'id' => $agent_id,
    
    );

 $agent = DB::LimitQuery('agent', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY id DESC',
        
         'size' => $pagesize,
        
         'offset' => $offset,
        
        ));

 include template('editagent');
