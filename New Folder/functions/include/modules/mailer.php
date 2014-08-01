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

function mail_custom($emails = array(), $subject, $message)
{
    
     global $INI;
    
    
    
     include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/lang/email_subject.php');
    
     settype($emails, 'array');
    
    
    
     $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'UTF-8',
        
        );
    
    
    
     $from = $INI['mail']['from'];
    
     $to = $INI['mail']['from']; //array_shift($emails);
    
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options, $emails);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options, $emails);
        
         } 
    
    } 

function gift_coupon($deals, $coupon, $user, $order, $userExist)
{
    
     global $INI;
    
    
    
     $vars = array(
        
        'deals' => $deals,
        
         'coupon' => $coupon,
        
         'user' => $user,
        
         'order' => $order,
        
         'userExist' => $userExist,
        
        );
    
     $message = render('mail_gift', $vars);
    
     // $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
    $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'UTF-8',
        
        );
    
    
    
     $from = $INI['mail']['from'];
    
     $to = $order['giftemail'];
    
     $subject = $INI['system']['sitename'] . ': You have received a gift from ' . $user['realname'] . '(' . $user['email'] . ')';
    
    
    
    
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    
    
    
    
    $message = render('mail_gift_delivered', $vars);
    
     // $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
    $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'UTF-8',
        
        );
    
    
    
     $from = $INI['mail']['from'];
    
     $to = $user['email'];
    
     $subject = $INI['system']['sitename'] . ': Your gift has been delivered';
    
    
    
    
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    
    
    } 

function mail_coupon($deals, $coupon, $user)
{
    
     global $INI;
    
    
    
     $vars = array(
        
        'deals' => $deals,
        
         'coupon' => $coupon,
        
         'user' => $user,
        
        );
    
     $message = render('mail_coupon', $vars);
    
     // $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
    $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'UTF-8',
        
        );
    
    
    
     $from = $INI['mail']['from'];
    
     $to = $user['email'];
    
     $subject = $INI['system']['sitename'] . ' Notification: Congratulations! Your coupon is now valid.';
    
    
    
    
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    } 

function mail_purchase($deals, $user)
{
    
     global $INI;
    
    
    
     $vars = array(
        
        'deals' => $deals,
        
         'user' => $user,
        
        );
    
     $message = render('mail_purchase', $vars);
    
     // $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
    $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'UTF-8',
        
        );
    
    
    
     $from = $INI['mail']['from'];
    
     $to = $user['email'];
    
     $subject = 'Purchase Confirmation';
    
    
    
    
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    } 

function mail_sign($user)
{
    
     global $INI;
    
    
    
     include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/lang/email_subject.php');
    
     if (empty($user)) return true;
    
     $from = $INI['mail']['from'];
    
     $to = $user['email'];
    
    
    
     $vars = array('user' => $user,);
    
     $message = render('mail_sign_verify', $vars);
    
     $subject = $INI['system']['sitename'] . ' account verification';
    
    
    
     $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'utf-8',
        
        );
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    } 

function mail_sign_id($id)
{
    
     $user = Table::Fetch('user', $id);
    
     mail_sign($user);
    
    } 

function mail_sign_email($email)
{
    
     $user = Table::Fetch('user', $email, 'email');
    
     mail_sign($user);
    
    } 

function mail_repass($user)
{
    
     global $INI;
    
    
    
     include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/lang/email_subject.php');
    
     if (empty($user)) return true;
    
     $from = $INI['mail']['from'];
    
     $to = $user['email'];
    
    
    
     $vars = array('user' => $user,);
    
     $message = render('mail_repass', $vars);
    
     $subject = $INI['system']['sitename'] . ' password reset';
    
    
    
     $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'utf-8',
        
        );
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    } 

function mail_subscribe($city, $deals, $partner, $subscribe)

{
    
     global $INI;
    
    
    
     include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/lang/email_subject.php');
    
     $week = array('S', 'M', 'T', 'W', 'T', 'F', 'S');
    
     $today = date('m.d.Y') . $week[date('w')];
    
     $vars = array(
        
        'today' => $today,
        
         'deals' => $deals,
        
         'city' => $city,
        
         'subscribe' => $subscribe,
        
         'partner' => $partner,
        
         'fn_email' => $INI['subscribe']['helpemail'],
        
         'fn_mobile' => $INI['subscribe']['helpphone'],
        
         'notice_email' => $INI['mail']['reply'],
        
        );
    
     $message = render('mail_subscribe_deals', $vars);
    
     $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
    
     $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'UTF-8',
        
        );
    
     $from = $INI['mail']['from'];
    
     $to = $subscribe['email'];
    
     $subject = $INI['system']['sitename'] . " Today's Deal: {$deals['title']}";
    
    
    
     if ($INI['mail']['mail'] == 'mail') {
        
        Mailer::SendMail($from, $to, $subject, $message, $options);
        
         } else {
        
        Mailer::SmtpMail($from, $to, $subject, $message, $options);
        
         } 
    
    } 

