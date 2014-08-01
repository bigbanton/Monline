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

ob_start();

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();

$now = time();

$deals = DB::LimitQuery('deals', array(
        
        'condition' => $condition,
        
         'order' => 'ORDER BY stage ASC, end_time ASC, begin_time ASC, id ASC',
        
         'stage' => '1-featured,approved',
        
        
        
        ));

$livecounter = 0;

$missedcounter = 0;

foreach($deals AS $id => $one) {
    
    if ($one['end_time'] > $now && $one['state'] != 'soldout') {
        
        $one['picclass'] = 'isopen';
        
         $livecounter += 1;
        
         } 
    
    else {
        
        $one['picclass'] = 'soldout';
        
         $missedcounter += 1;
        
         } 
    
    $deals[$id] = $one;
    
    } 

/**
 * Start the output
 */

header("Content-Type: text/xml;charset=iso-8859-1");

 // connect to the database
echo '<?xml version="1.0" encoding="UTF-8"?> 

			<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';

 if ($livecounter > 0) {
    
    if (is_array($deals)) {
        
        foreach($deals AS $index => $one) {
            
            if ($one['picclass'] == 'isopen') {
                
                
                
                $url_product = $domain . "deals.php?id=" . $one['id'];
                
                
                
                 $date = ($one['begin_time'] > $now) ? $now - 1000 : $one['begin_time']; //Adjust the date for upcoming deals
                
                
                
                
                
/**
                 * display the date in the format Google expects:
                 * 
                 * 2006-01-29 for example
                 */
                
                
                
                 $displaydate = date("Y-m-d", $date);
                
                
                
                 // you can assign whatever changefreq and priority you like
                echo
                
                 '

							<url>

							<loc>' . $url_product . '</loc>

							<lastmod>' . $displaydate . '</lastmod>

							<changefreq>daily</changefreq>

							<priority>0.8</priority>

							</url>

						';
                
                 } 
            
            } 
        
        } 
    
    } 

// close the XML attribute
echo

'</urlset>';

?>