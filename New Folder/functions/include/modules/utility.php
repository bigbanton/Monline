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

function get_city($ip = null, $ip_pref = true)
{
    
     global $INI;
    
     if (!file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/geoip/GeoLiteCity.dat')) return false;
    
     $cities = option_category('city');
    
     $ip = ($ip) ? $ip : Utility::GetRemoteIP();
    
     $IPDetail = array();
    
     require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/geoip/geoipcity.inc');
    
     $gi = geoip_open(dirname(dirname(dirname(dirname(__FILE__)))) . '/geoip/GeoLiteCity.dat', GEOIP_STANDARD);
    
     $location = GeoIP_record_by_addr($gi, $_SERVER['REMOTE_ADDR']);
    
     $IPDetail['city'] = ucwords($location->city);
    
     $IPDetail['country'] = ucwords(geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']));
    
     geoip_close($gi);
    
     if (strpos(strtolower($IPDetail['city']), "unknown")) $IPDetail['city'] = 'unknown';
    
     foreach($cities AS $cid => $cname) {
        
        if (strtolower($cname) == strtolower($IPDetail['city'])) return Table::Fetch('cities', $cid);
        
         } 
    
    if (!$ip_pref) return strtoupper($IPDetail['city'] . ', ' . $IPDetail['country']);
    
     return array();
    
    } 

function mail_zd($email)
{
    
     global $option_mail;
    
     if (! Utility::ValidEmail($email)) return false;
    
     preg_match('#@(.+)$#', $email, $m);
    
     $suffix = strtolower($m[1]);
    
     return $option_mail[$suffix];
    
    } 

function nanooption($string)
{
    
     if (preg_match_all('#{(.+)}#U', $string, $m)) {
        
        return $m[1];
        
         } 
    
    return array();
    
    } 

global $striped_field;

$striped_field = array(
    
    'username',
    
     'realname',
    
     'name',
    
     'tilte',
    
     'email',
    
     'address',
    
     'mobile',
    
     'url',
    
     'logo',
    
     'contact',
    
    );

global $option_gender;

$option_gender = array(
    
    'M' => 'Male',
    
     'F' => 'Female',
    
    );

global $option_pay;

$option_pay = array(
    
    'pay' => 'Paid',
    
     'unpay' => 'Unpaid',
    
    );

global $option_service;

$option_service = array(
    
    'paypal' => 'Paypal',
    
     'cash' => 'Cash',
    
     'credit' => 'Credit',
    
     'other' => 'Others',
    
    );

global $option_delivery;

$option_delivery = array(
    
    'express' => 'Express Delivery',
    
     'coupon' => 'Coupon',
    
     'pickup' => 'Selfwithdraw',
    
    );

global $option_flow;

$option_flow = array(
    
    'buy' => 'Buy',
    
     'invite' => 'Invite',
    
     'store' => 'Store',
    
     'withdraw' => 'Withdraw',
    
     'coupon' => 'Rebate',
    
     'refund' => 'Refund',
    
     'register' => 'Register',
    
     'charge' => 'Charge',
    
    );

global $option_mail;

$option_mail = array(
    
    'gmail.com' => 'https://mail.google.com/',
    
     'yahoo.com' => 'http://mail.yahoo.com/',
    
    );

global $option_cond;

$option_cond = array(
    
    'Y' => 'Group as number of buyers',
    
     'N' => 'Group as numbers of product',
    
    );

