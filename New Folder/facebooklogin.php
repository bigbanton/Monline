<?php

ob_start();

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();

// error_reporting(E_ALL);

$fb = new Facebook(APIKEY, SECRET);

$uid = $fb->get_loggedin_user();

if ($uid) {
    
    // echo 'verified';
    
    
    $api_client = new FacebookRestClient(APIKEY, SECRET, null);
    
     // echo '<pre>';
    // print_r($api_client->users_getInfo($uid, 'email'));
    
    
    $user_details = $api_client->users_getInfo($uid, 'last_name, first_name, pic_square, profile_url, sex, current_location, name, email');
    
    
    
     $userExist = DB::GetTableRow('user', array(
            
            'facebook_uid' => $user_details[0]['uid'],
            
            ));
    
    
    
     if ($userExist) {
        
        $user_id = $userExist['id'];
        
        
        
         // $update_image = save_facebook_image($user_details[0]['pic_square'],$user_id);
        DB::Update('user', $user_id, array('avatar' => $update_image), 'id');
        
        
        
         DB::Update('user', $user_id, array('username' => 'FB_' . $user_details[0]['first_name']), 'id');
        
         } else {
        
        $user_row['password'] = ZUser::GenPassword($user_row['password']);
        
         $user_row['create_time'] = $user_row['login_time'] = time();
        
         $user_row['ip'] = Utility::GetRemoteIp();
        
         $user_row['secret'] = md5(Utility::GenSecret(12));
        
        
        
         $user_row['gender'] = $user_details[0]['sex'] == 'male' ? 'M' : 'F';
        
         $user_row['realname'] = $user_details[0]['name'];
        
        
        
         $user_row['username'] = $user_details[0]['first_name'];
        
        
        
         $user_row['facebook_uid'] = $user_details[0]['uid'];
        
         $user_row['facebook_url'] = $user_details[0]['profile_url'];
        
         // $user_row['facebook_pic'] = $user_details[0]['pic_square'];
        
        
        $user_id = ZUser::Create($user_row);
        
        
        
         // save facebook image and update the path in database
        // $update_image = save_facebook_image($user_row['facebook_pic'],$user_id);
        // DB::Update('user',$user_id,array('avatar'=>$update_image),'id');
        
        
        // print_r($facebook->api_client);
        // print_r($user_details);
        
        
        } 
    
    
    
    // $user_row['fname'] = $user_details[0]['first_name'];
    // echo $user_row['fname'];
    // exit();
    Session::Set('user_id', $user_id);
    
     // echo $user_id;
    ZLogin::Remember($login_user);
    
     Utility::Redirect('index.php');
    
     exit;
    
    
    
    } else {
    
    Session::Set('error', 'Unable to verify your Facebook ID');
    
     Utility::Redirect('index.php');
    
    } 

/**
 * $api_client = new FacebookRestClient(APIKEY, SECRET, null);
 * 
 * echo '<pre>';
 * 
 * print_r($api_client->users_getInfo($uid, 'email')); 
 * 
 * 
 * 
 * $user_details = $api_client->users_getInfo($uid, 'last_name, first_name, pic_square, profile_url, sex, current_location, name, email');
 * 
 * 
 * 
 * //print_r($facebook->api_client); 
 * 
 * print_r($user_details);
 * 
 * //print_r($uid);
 * 
 * echo '</pre>';
 */

?>