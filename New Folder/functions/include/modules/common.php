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

import('current');

import('utility');

import('mailer');

import('sms');

import('upgrade');

function template($tFile)
{
    
     global $INI;
    
     if (0 === strpos($tFile, 'manage')) {
        
        return __template($tFile);
        
         } 
    
    if ($INI['skin']['template']) {
        
        $templatedir = DIR_TEMPLATE . '/' . $INI['skin']['template'];
        
         $checkfile = $templatedir . '/template_header.html';
        
         if (file_exists($checkfile)) {
            
            return __template($INI['skin']['template'] . '/' . $tFile);
            
             } 
        
        } 
    
    return __template($tFile);
    
    } 

function render($tFile, $vs = array())
{
    
     ob_start();
    
     foreach($GLOBALS AS $_k => $_v) {
        
        ${$_k} = $_v;
        
         } 
    
    foreach($vs AS $_k => $_v) {
        
        ${$_k} = $_v;
        
         } 
    
    include template($tFile);
    
     return render_hook(ob_get_clean());
    
    } 

function render_hook($c)
{
    
     global $INI;
    
     $c = preg_replace('#href="/#i', 'href="' . BASE_REF . '/', $c);
    
     $c = preg_replace('#src="/#i', 'src="' . BASE_REF . '/', $c);
    
     $c = preg_replace('#action="/#i', 'action="' . BASE_REF . '/', $c);
    
     $c = preg_replace('/url\(\//i', 'url(' . BASE_REF . '/', $c);
    
     $c = preg_replace('/url\("\//i', 'url("' . BASE_REF . '/', $c);
    
     $c = preg_replace('/url\(\'\//i', 'url(\'' . BASE_REF . '/', $c);
    
     $c = preg_replace('/\'href\':"\//i', '\'href\':"' . BASE_REF . '/', $c);
    
     $page = strval($_SERVER['REQUEST_URI']);
    
     return $c;
    
    } 

function output_hook($c)
{
    
     global $INI;
    
     if (0 == abs(intval($INI['system']['gzip']))) die($c);
    
     $HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
    
     if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false)
        
         $encoding = 'x-gzip';
    
     else if (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false)
        
         $encoding = 'gzip';
    
     else $encoding == false;
    
     if (function_exists('gzencode') && $encoding) {
        
        $c = gzencode($c);
        
         header("Content-Encoding: {$encoding}");
        
         } 
    
    $length = strlen($c);
    
     header("Content-Length: {$length}");
    
     die($c);
    
    } 

$lang_properties = array();

function I($key)
{
    
     global $lang_properties, $LC;
    
     if (!$lang_properties) {
        
        $ini = DIR_ROOT . '/i18n/' . $LC . '/properties.ini';
        
         $lang_properties = Config::Instance($ini);
        
         } 
    
    return isset($lang_properties[$key]) ?
    
     $lang_properties[$key] : $key;
    
    } 

function json($data, $type = 'eval')
{
    
     $type = strtolower($type);
    
     $allow = array('eval', 'alert', 'updater', 'dialog', 'mix', 'refresh');
    
     if (false == in_array($type, $allow))
        
         return false;
    
     Output::Json(array('data' => $data, 'type' => $type,));
    
    } 

function redirect($url = null)
{
    
     header("Location: {$url}");
    
    } 

function write_php_file($array, $filename = null)
{
    
     $v = "<?php\r\n\$INI = ";
    
     $v .= var_export($array, true);
    
     $v .= ";\r\n?>";
    
     return file_put_contents($filename, $v);
    
    } 

function write_ini_file($array, $filename = null)
{
    
     $ok = null;
    
     if ($filename) {
        
        $s = ";;;;;;;;;;;;;;;;;;\r\n";
        
         $s .= ";;SYS_INIFILE\r\n";
        
         $s .= ";;;;;;;;;;;;;;;;;;\r\n";
        
         } 
    
    foreach($array as $k => $v) {
        
        if (is_array($v)) {
            
            if ($k != $ok) {
                
                $s .= "\r\n[{$k}]\r\n";
                
                 $ok = $k;
                
                 } 
            
            $s .= write_ini_file($v);
            
             } else {
            
            if (trim($v) != $v || strstr($v, "["))
                
                 $v = "\"{$v}\"";
            
             $s .= "$k = \"{$v}\"\r\n";
            
             } 
        
        } 
    
    
    
    if (!$filename) return $s;
    
     return file_put_contents($filename, $s);
    
    } 

function save_config($type = 'ini')
{
    
     global $INI;
    $q = ZSystem::GetSaveINI($INI);
    
     if (strtoupper($type) == 'INI') {
        
        if (!is_writeable(SYS_INIFILE)) return false;
        
         return write_ini_file($q, SYS_INIFILE);
        
         } 
    
    if (strtoupper($type) == 'PHP') {
        
        if (!is_writeable(SYS_PHPFILE)) return false;
        
         return write_php_file($q, SYS_PHPFILE);
        
         } 
    
    return false;
    
    } 

function save_system($ini)
{
    
     $system = Table::Fetch('system', 1);
    
     $ini = ZSystem::GetUnsetINI($ini);
    
     $value = Utility::ExtraEncode($ini);
    
     $table = new Table('system', array('value' => $value));
    
     if ($system) $table->SetPK('id', 1);
    
     return $table->update(array('value'));
    
    } 

/**
 * user relative
 */

function need_login($force = false)
{
    
     if (isset($_SESSION['user_id'])) {
        
        if (is_post()) {
            
            unset($_SESSION['loginpage']);
            
             unset($_SESSION['loginpagepost']);
            
             } 
        
        return $_SESSION['user_id'];
        
         } 
    
    if (is_get()) {
        
        Session::Set('loginpage', $_SERVER['REQUEST_URI']);
        
         } else {
        
        Session::Set('loginpage', $_SERVER['HTTP_REFERER']);
        
         Session::Set('loginpagepost', json_encode($_POST));
        
         } 
    
    return redirect(BASE_REF . '/account/loginup.php');
    
    } 

function need_post()
{
    
     return is_post() ? true : redirect(BASE_REF . '/index.php');
    
    } 

function need_manager($super = false)
{
    
     if (! is_manager()) {
        
        redirect(BASE_REF . '/account/login.php');
        
         } 
    
    if (! $super) return true;
    
     if (abs(intval($_SESSION['user_id'])) == 1) return true;
    
     return redirect(BASE_REF . '/manage/misc/index.php');
    
    } 

function need_partner($reqd = false)
{
    
     return is_partner($reqd) ? true : redirect(BASE_REF . '/business/login.php');
    
    } 

function need_dealer()
{
    
     if (!is_manager()) {
        
        if (!is_partner(true)) redirect(BASE_REF . '/business/login.php');
        
         return true;
        
         redirect(BASE_REF . '/account/login.php');
        
         } 
    
    if (abs(intval($_SESSION['user_id'])) == 1) return true;
    
     return redirect(BASE_REF . '/manage/misc/index.php');
    
    } 

function need_auth($b = true)
{
    
     global $AJAX, $INI, $login_user;
    
     if (is_string($b)) {
        
        $auths = $INI['authorization'][$login_user['id']];
        
         $b = is_manager(true) || in_array($b, $auths);
        
         } 
    
    if (true === $b) {
        
        return true;
        
         } 
    
    if ($AJAX) json(TEXT_EN_PERMISSION_DENIED_EN, 'alert');
    
     Session::Set('error', TEXT_EN_PERMISSION_DENIED_EN);
    
     redirect(BASE_REF . '/account/login.php');
    
    } 

function is_manager($super = false)
{
    
     global $login_user;
    
     if (! $super) return ($login_user['manager'] == 'Y');
    
     return $login_user['id'] == 1;
    
    } 

function is_partner($reqd = false)
{
    
     if ($_SESSION['agent_id'] && !$reqd) return ($_SESSION['agent_id'] > 0);
    
     return ($_SESSION['partner_id'] > 0);
    
    } 

function is_newbie()
{
    return (cookieget('newbie') != 'N');
} 

function is_get()
{
    return ! is_post();
} 

function is_post()
{
    
     return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    
    } 

function is_login()
{
    
     return isset($_SESSION['user_id']);
    
    } 

function get_loginpage($default = null)
{
    
     $loginpage = Session::Get('loginref', true);
    
     if ($loginpage) return $loginpage;
    
     if ($default) return $default;
    
     return BASE_REF . '/index.php';
    
    } 

function cookie_city($city)
{
    
     global $INI;
    
     if ($city) {
        
        cookieset('city', $city['id']);
        
         return $city;
        
         } 
    
    $city_id = cookieget('city');
    
     if (!$city_id) {
        
        $city = get_city();
        
         if (!$city) {
            
            $city = Table::Fetch('cities', $INI['hotcity'][0]);
            
             } 
        
        if ($city) cookie_city($city);
        
         return $city;
        
         } else {
        
        $intercity = Table::Fetch('cities', $city_id);
        
         if ($intercity) return cookie_city($intercity);
        
         $city = Table::Fetch('cities', $INI['hotcity'][0]);
        
         } 
    
    return $city;
    
    } 

function cookieset($k, $v, $expire = 0)
{
    
     $pre = substr(md5($_SERVER['HTTP_HOST']), 0, 4);
    
     $k = "{$pre}_{$k}";
    
     if ($expire == 0) {
        
        $expire = time() + 365 * 86400;
        
         } else {
        
        $expire += time();
        
         } 
    
    setCookie($k, $v, $expire, '/');
    
    } 

function cookieget($k)
{
    
     $pre = substr(md5($_SERVER['HTTP_HOST']), 0, 4);
    
     $k = "{$pre}_{$k}";
    
     return strval($_COOKIE[$k]);
    
    } 

function moneyit($k)
{
    
     return rtrim(rtrim(sprintf('%.2f', $k), '2'), '.');
    
    } 

function debug($v, $e = false)
{
    
     global $login_user_id;
    
     if ($login_user_id == 100000) {
        
        echo "<pre>";
        
         var_dump($v);
        
         if ($e) exit;
        
         } 
    
    } 

function getparam($index = 0, $default = 0)
{
    
     if (is_numeric($default)) {
        
        $v = abs(intval($_GET['param'][$index]));
        
         } else $v = strval($_GET['param'][$index]);
    
     return $v ? $v : $default;
    
    } 

function getpage()
{
    
     $c = abs(intval($_GET['page']));
    
     return $c ? $c : 1;
    
    } 

function pagestring($count, $pagesize)
{
    
     $p = new Pager($count, $pagesize, 'page');
    
     return array($pagesize, $p->offset, $p->genBasic());
    
    } 

function uencode($u)
{
    
     return base64_encode(urlEncode($u));
    
    } 

function udecode($u)
{
    
     return urlDecode(base64_decode($u));
    
    } 

/**
 * share link
 */

function share_facebook($deals)
{
    
     global $login_user_id;
    
     global $INI;
    
     if ($deals) {
        
        $query = array(
            
            'u' => $INI['system']['wwwprefix'] . "/deals.php?id={$deals['id']}&r={$login_user_id}",
            
             't' => $deals['title'],
            
            );
        
         } 
    
    else {
        
        $query = array(
            
            'u' => $INI['system']['wwwprefix'] . "/process.php?r={$login_user_id}",
            
             't' => $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
            
            );
        
         } 
    
    
    
    $query = http_build_query($query);
    
     return 'http://www.facebook.com/sharer.php?' . $query;
    
    } 

function share_twitter($deals)
{
    
     global $login_user_id;
    
     global $INI;
    
     if ($deals) {
        
        $query = array(
            
            'status' => $INI['system']['wwwprefix'] . "/deals.php?id={$deals['id']}&r={$login_user_id}" . ' ' . $deals['title'],
            
            );
        
         } 
    
    else {
        
        $query = array(
            
            'status' => $INI['system']['wwwprefix'] . "/process.php?r={$login_user_id}" . ' ' . $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
            
            );
        
         } 
    
    
    
    $query = http_build_query($query);
    
     return 'http://twitter.com/?' . $query;
    
    } 

function share_mail($deals)
{
    
     global $login_user_id;
    
     global $INI;
    
     if (!$deals) {
        
        $deals = array(
            
            'title' => $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
            
            );
        
         } 
    
    $pre[] = "Got a good webiste - {$INI['system']['sitename']}, they organise a great deals-buy deal everyday, worth to check!";
    
     if ($deals['id']) {
        
        $pre[] = "Today's Deal: {$deals['title']}";
        
         $pre[] = "You must interest: ";
        
         $pre[] = $INI['system']['wwwprefix'] . "/deals.php?id={$deals['id']}&r={$login_user_id}";
        
         $pre = mb_convert_encoding(join("\n\n", $pre), 'UTF-8', 'UTF-8');
        
         $sub = "Interested in: {$deals['title']}";
        
         } else {
        
        $sub = $pre[] = $deals['title'];
        
         } 
    
    $sub = mb_convert_encoding($sub, 'UTF-8', 'UTF-8');
    
     $query = array('subject' => $sub, 'body' => $pre,);
    
    
    
     $query = http_build_query($query);
    
     $query1 = str_replace("+", " ", $query);
    
     return 'mailto:?' . $query1;
    
    } 

function domainit($url)
{
    
     if (strpos($url, '//')) {
        preg_match('#[//]([^/]+)#', $url, $m);
        
        } else {
        preg_match('#[//]?([^/]+)#', $url, $m);
    } 
    
    return $m[1];
    
    } 

// that the recursive feature on mkdir() is broken with PHP 5.0.4 for
function RecursiveMkdir($path)
{
    
     if (!file_exists($path)) {
        
        RecursiveMkdir(dirname($path));
        
         @mkdir($path, 0777);
        
         } 
    
    } 

function upload_image($inputname, $image = null, $type = 'deals', $width = 440)
{
    
     $year = date('Y');
    
     $day = date('md');
    
     $n = time() . rand(1000, 9999) . '.jpg';
    
     $z = $_FILES[$inputname];
    
     if ($z && strpos($z['type'], 'image') === 0 && $z['error'] == 0) {
        
        if (!$image) {
            
            RecursiveMkdir(IMG_ROOT . '/' . "{$type}/{$year}/{$day}");
            
             $image = "{$type}/{$year}/{$day}/{$n}";
            
             $path = IMG_ROOT . '/' . $image;
            
             } else {
            
            RecursiveMkdir(dirname(IMG_ROOT . '/' . $image));
            
             $path = IMG_ROOT . '/' . $image;
            
             } 
        
        if ($type == 'user') {
            
            Image::Convert($z['tmp_name'], $path, 48, 48, Image::MODE_CUT);
            
             } 
        
        else if ($type == 'deals') {
            
            move_uploaded_file($z['tmp_name'], $path);
            
             } 
        
        return $image;
        
         } 
    
    // reimageload();
    return $image;
    
    } 

function remove_image($imgname, $image)
{
    
     $imgname = DIR_BACKEND . '/themes/' . int_user_image($image);
    
     if (file_exists($imgname)) {
        @unlink($imgname);
        
         return true;
        
         } 
    
    else {
        
        return false;
        
         } 
    
    } 

function remove_prod_image($image)
{
    
     if (file_exists($image)) {
        @unlink($image);
        
         return true;
        
         } 
    
    else {
        
        return false;
        
         } 
    
    } 

function upload_image_user($inputname, $image = null, $type = 'deals', $width = 440)
{
    
     $year = date('Y');
    
     $day = date('md');
    
     $n = time() . rand(1000, 9999) . '.jpg';
    
     $z = $_FILES[$inputname];
    
     if ($z && strpos($z['type'], 'image') === 0 && $z['error'] == 0) {
        
        if (!$image) {
            
            RecursiveMkdir(IMG_ROOT . '/' . "{$type}/{$user_id}");
            
             $image = "{$type}/{$year}/{$day}/{$n}";
            
             $imagename = basename($image);
            
             $path = IMG_ROOT . '/' . "{$type}/{$user_id}/" . $imagename;
            
             } else {
            
            RecursiveMkdir(IMG_ROOT . '/' . "{$type}/{$user_id}");
            
             $imagename = basename($image);
            
             $path = IMG_ROOT . '/' . "{$type}/{$user_id}/" . $imagename;
            
             } 
        
        if ($type == 'user') {
            
            Image::Convert($z['tmp_name'], $path, 48, 48, Image::MODE_CUT);
            
             } 
        
        else if ($type == 'team') {
            
            move_uploaded_file($z['tmp_name'], $path);
            
             } 
        
        $imagename = "{$type}/{$user_id}/" . $imagename;
        
         return $imagename;
        
         } 
    
    // reimageload();
    return $imagename;
    
    } 

function save_facebook_image($facebookimage, $user_id)
{
    
     $image = basename($facebookimage);
    
     $path = "user/{$user_id}/{$image}";
    
     $img = IMG_ROOT . '/' . "user/{$user_id}/{$image}";
    
     RecursiveMkdir(IMG_ROOT . '/' . "user/{$user_id}");
    
     file_put_contents($img, file_get_contents($facebookimage));
    
     return $path;
    
    } 

function int_user_image($image = null)
{
    
     global $INI;
    
     if (!$image) {
        
        return 'default_user_av.png';
        
         } 
    
    return $image;
    
    } 

function user_image($image = null)
{
    
     global $INI;
    
     if (!file_exists(DIR_BACKEND . '/themes/' . $image)) {
        
        return HTTP_Protocol() . WWW_ROOT . '/image.php?img=/user/default_user.jpg';
        
         } 
    
    return HTTP_Protocol() . WWW_ROOT . '/image.php?img=/' . $image;
    
    } 

function deals_image($image = null)
{
    
     global $INI;
    
     if (!$image) return null;
    
     return HTTP_Protocol() . WWW_ROOT . '/image.php?img=/' . $image;
    
    } 

function userreview($content)
{
    
     $line = preg_split("/[\n\r]+/", $content, -1, PREG_SPLIT_NO_EMPTY);
    
     $r = '<ul>';
    
     foreach($line AS $one) {
        
        $c = explode('|', htmlspecialchars($one));
        
         $c[2] = $c[2] ? $c[2] : '/';
        
         $r .= "<li>{$c[0]}<span>--<a href=\"{$c[2]}\" target=\"_blank\">{$c[1]}</a>";
        
         $r .= ($c[3] ? "({$c[3]})":'') . "</span></li>\n";
        
         } 
    
    return $r . '</ul>';
    
    } 

function deals_state(&$deals)
{
    
     $deals['close_time'] = 0;
    
     if ($deals['now_number'] >= $deals['min_number']) {
        
        if ($deals['max_number'] > 0) {
            
            if ($deals['now_number'] >= $deals['max_number']) {
                
                if ($deals['close_time'] == 0) {
                    
                    $deals['close_time'] = $deals['end_time'];
                    
                     } 
                
                return $deals['state'] = 'soldout';
                
                 } 
            
            } 
        
        if ($deals['end_time'] <= time()) {
            
            $deals['close_time'] = $deals['end_time'];
            
             } 
        
        return $deals['state'] = 'success';
        
         } else {
        
        if ($deals['end_time'] <= time()) {
            
            $deals['close_time'] = $deals['end_time'];
            
             return $deals['state'] = 'failure';
            
             } 
        
        } 
    
    return $deals['state'] = 'none';
    
    } 

function current_deals($city_id = 0)
{
    
     $today = time();
    
     settype($city_id, 'array');
    $city_id[] = 0;
    
     $cond = array(
        
        'city_id' => $city_id,
        
         "begin_time <= {$today}",
        
         "end_time > {$today}",
        
         'stage' => array('1-featured', 'approved'),
        
        );
    
     $deals = DB::LimitQuery('deals', array(
            
            'condition' => $cond,
            
             'one' => true,
            
             'order' => 'ORDER BY stage ASC, city_id DESC,begin_time DESC,id DESC',
            
            ));
    
    
    
     if (!$deals) {
        
        $cond = array(
            
            'city_id' => $city_id,
            
             "begin_time <= {$today}",
            
             "end_time > {$today}",
            
             'stage' => array('1-featured', 'approved'),
            
            );
        
         $deals = DB::LimitQuery('deals', array(
                
                'condition' => $cond,
                
                 'one' => true,
                
                 'order' => 'ORDER BY stage ASC, city_id DESC,begin_time DESC,id DESC',
                
                ));
        
        
        
        
        
         } 
    
    return $deals;
    
    } 

function state_explain($deals, $error = 'false')
{
    
     $state = deals_state($deals);
    
     $state = strtolower($state);
    
     switch ($state) {
    
    case 'none': return 'is active';
        
         case 'soldout': return 'is soldout';
        
         case 'failure': if ($error) return 'This deal failed';
        
         case 'success': return 'is tipped';
        
         default: return 'is over';
        
         } 
    
    } 

function get_zones($zone = null)
{
    
     $zones = array(
        
        'city' => 'Cities',
        
         'group' => 'Country',
        
         // 'public' => 'Forum',
        );
    
     if (!$zone) return $zones;
    
     if (!in_array($zone, array_keys($zones))) {
        
        $zone = 'city';
        
         } 
    
    return array($zone, $zones[$zone]);
    
    } 

function down_xls($data, $keynames, $name = 'datacsv')
{
    
     $xls[] = implode(",", array_values($keynames));
    
     foreach($data As $o) {
        
        $line = array();
        
         foreach($keynames AS $k => $v) {
            
            $line[] = $o[$k];
            
             } 
        
        $xls[] = implode(",", $line);
        
         } 
    
    $xls = join("\n", $xls);
    
     // header('Content-Type: application/force-download');
    header('Content-Type: application/download');
    
     header('Content-type: application/csv');
    
     header('Content-Disposition: attachment;filename="' . $name . '.csv"');
    
     die(mb_convert_encoding($xls, 'UTF-8', 'UTF-8'));
    
    } 

function option_category($zone = 'city', $force = false)
{
    
     $cache = $force ? 0 : 86400 * 30;
    
     $cates = DB::LimitQuery('cities', array(
            
            'condition' => array('zone' => $zone,),
            
             'cache' => $cache,
            
            ));
    
     return Utility::OptionArray($cates, 'id', 'name');
    
    } 

function backup_write_file($sql, $filename)
{
    
     $re = true;
    
     $backupdir = DIR_BACKEND . '/backup';
    
     if (!@$fp = fopen("{$backupdir}/{$filename}", "w+")) {
        
        return "failed to open target file";
        
         } 
    
    $sql = "SET NAMES UTF8;\n{$sql}";
    
     if (!@fwrite($fp, $sql)) {
        return "failed to write file";
    } 
    
    if (!@fclose($fp)) {
        return "failed to close target file";
    } 
    
    return true;
    
    } 

function backup_down_file($sql, $filename)
{
    
     ob_get_clean();
    
     header("Content-Encoding: none");
    
     header("Content-Type: " . (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
    
     header("Content-Disposition: " . (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ') . "filename=" . $filename);
    
     header("Content-Length: " . strlen($sql));
    
     header("Pragma: no-cache");
    
     header("Expires: 0");
    
     die($sql);
    
    } 

function backup_make_header($table)
{
    
     $sql = "DROP TABLE IF EXISTS `" . $table . "`;\n";
    
     $result = DB::GetQueryResult("SHOW CREATE TABLE `{$table}`", true);
    
     $tmp = preg_replace("/[\r\n]+/", '', $result['create table']);
    
     $sql .= $tmp . ";\n";
    
     return $sql;
    
    } 

function backup_make_record($table, $r)
{
    
     $comma = null;
    
     $num_fields = count($r);
    $r = array_values($r);
    
     $sql .= "INSERT INTO `{$table}` VALUES(";
    
     for($i = 0; $i < $num_fields; $i++) {
        
        if (is_null($r[$i])) {
            
            $sql .= ($comma . "NULL");
            
             } else {
            
            $sql .= ($comma . "'" . mysql_escape_string($r[$i]) . "'");
            
             } 
        
        $comma = ",";
        
         } 
    
    $sql .= ");\n";
    
     return $sql;
    
    } 

function backup_import($fname)
{
    
     global $db;
    
     $sqls = file($fname);
    
     foreach($sqls as $sql) {
        
        str_replace("\r", "", $sql);
        
         str_replace("\n", "", $sql);
        
         DB::Query($sql);
        
         } 
    
    return true;
    
    } 

function cat2arr()
{
    
    
    
     $arr = array();
    
     $index = 0;
    
    
    
     $groups = DB::LimitQuery('category', array(
            
            'condition' => array(),
            
            ));
    
    
    
     foreach ($groups as $category) {
        
        $index++;
        
         $arr[] = "{$category['name']}##{$category['desc']}##{$index}";
        
         } 
    
    
    
    return $arr;
    
    } 

function ThisPageURL()
{
    
     $pageURL = 'http';
    
     if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    } 
    
    $pageURL .= "://";
    
     if ($_SERVER["SERVER_PORT"] != "80") {
        
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        
         } else {
        
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        
         } 
    
    return $pageURL;
    
    } 

function HTTP_Protocol()
{
    
     $pageURL = 'http';
    
     if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    } 
    
    $pageURL .= "://";
    
     return $pageURL;
    
    } 

function dollars_saved()
{
    
     $deals_for_stat = DB::LimitQuery('deals', array('condition' => array('now_number >= min_number',),));
    
    
    
     $total_saving = 0;
    
    
    
     foreach($deals_for_stat as $deal_data_for_stat) {
        
        $deal_saving = $deal_data_for_stat['market_price'] - $deal_data_for_stat['deals_price'];
        
         $total_saving += $deal_saving * $deal_data_for_stat['now_number'];
        
         } 
    
    
    
    $insta_for_stat = DB::LimitQuery('insta', array('condition' => array('now_number >= 1',),));
    
    
    
     foreach($insta_for_stat as $deal_data_for_stat) {
        
        $deal_saving = $deal_data_for_stat['market_price'] - $deal_data_for_stat['deals_price'];
        
         $total_saving += $deal_saving * $deal_data_for_stat['now_number'];
        
         } 
    
    
    
    return $total_saving;
    
    } 

function list_cities($citystring, $printlist = 0, $returnarray = 0, $delimiter = '<br/>')
{
    
     $citylist = array();
    
     if (!$citystring) return 'All Cities';
    
     $arr = @explode(',', $citystring);
    
     foreach ($arr as $cityid) {
        
        $city = ($cityid) ? Table::Fetch('cities', $cityid, 'id') : array('name' => 'All Cities');
        
         if ($printlist) echo $city['name'] . $delimiter;
        
         $citylist[] = $city;
        
         } 
    
    return ($returnarray)?$citylist:'';
    
    } 
