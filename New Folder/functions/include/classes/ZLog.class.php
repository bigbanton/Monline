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

class ZLog

 {
    
    static public function Log($userid = 0, $desc, $comments = '', $iserror = 0)
    {
        
         global $login_user_id;
        
        
        
        // try {
         $activity_row = array();
        
        
        
         $table = new Table('log', $activity_row);
        
        
        
         $activity_row['userid'] = $userid; //($userid) ? $userid : $login_user_id;
        
        
         $activity_row['description'] = $desc;
        
         $activity_row['datetime'] = time();
        
         $activity_row['comments'] = $comments;
        
         $activity_row['error'] = $iserror;
        
        
        
         DB::Insert('log', $activity_row);
        
        // } catch (Exception $e) {
        
        
        // echo 'Caught exception: ',  $e->getMessage(), "\n"; exit;
        
        
        // }
        
        
        
        
         } 
    
    } 

