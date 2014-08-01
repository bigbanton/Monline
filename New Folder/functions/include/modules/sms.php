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

function sms_send($phone, $content)
{
    
     global $INI;
    
     if (mb_strlen($content, 'UTF-8') < 20) {
        
        return TEXT_EN_SMS_NOT_VALIDATED_EN;
        
         } 
    
    
/**
     * please set your own SMS gateway if you want to enable this feature in your own country
     * 
     * $user = $INI['sms']['user']; 
     * 
     * $pass = strtolower(md5($INI['sms']['pass']));
     * 
     * $content = urlEncode($content);
     * 
     * $api = "http://www.gripsell.com/sms?user={$user}&pass={$pass}&phones={$phone}&content={$content}";
     * 
     * $res = Utility::HttpRequest($api);
     * 
     * return trim(strval($res))=='+OK' ? true : strval($res);
     */
    
    } 

function sms_coupon($coupon)
{
    
     global $INI;
    
     $coupon_user = Table::Fetch('user', $coupon['user_id']);
    
     if ($coupon['consume'] == 'Y'
        
         || $coupon['expire_time'] < strtotime(date('Y-m-d'))) {
        
        return $INI['system']['couponname'] . ' is expired';
        
         } 
    
    else if (!Utility::IsMobile($coupon_user['mobile'])) {
        
        return TEXT_EN_PLEASE_PROVIDE_VALID_MOBILE_EN;
        
         } 
    
    
    
    $deals = Table::Fetch('deals', $coupon['deals_id']);
    
     $user = Table::Fetch('user', $coupon['user_id']);
    
     $coupon['end'] = date('Y-n-j', $coupon['expire_time']);
    
     $coupon['name'] = $deals['product'];
    
     $content = render('manage_tpl_smscoupon', array(
            
            'coupon' => $coupon,
            
             'user' => $user,
            
            ));
    
     $content = trim(preg_replace("/[\s]+/", '', $content));
    
     if (true === ($code = sms_send($coupon_user['mobile'], $content))) {
        
        Table::UpdateCache('coupon', $coupon['id'], array(
                
                'sms' => array('`sms` + 1'),
                
                ));
        
         return true;
        
         } 
    
    return $code;
    
    } 

