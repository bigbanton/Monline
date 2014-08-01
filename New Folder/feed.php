<?php

/**
 * //File information must not be removed
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

header('Content-Type: application/rss+xml;charset=UTF-8;');

ob_start();

require_once(dirname(__FILE__) . '/app.php');

$ob_content = ob_get_clean();

$ename = strval($_GET['ename']);

if ($ename != 'none') {
    
    
    
    $city = DB::LimitQuery('cities', array(
            
            
            
            'condition' => array(
                
                
                
                'zone' => 'city',
                
                
                
                 'ename' => $ename,
                
                
                
                ),
            
            
            
             'one' => true,
            
            
            
            ));
    
    
    
    } 

$deals = current_deals($city['id']);

$rss = new UniversalFeedCreator();

$rss->useCached();

$rss->title = "{$INI['system']['sitename']} Today's Deal";

$rss->description = "{$INI['system']['sitename']} Deal of The Day";

$rss->link = "{$INI['system']['wwwprefix']}";

$rss->syndicationURL = $INI['system']['wwwprefix'] . '/' . $PHP_SELF;

$image = new FeedImage();

$image->title = $INI['system']['sitename'];

$image->url = "{$INI['system']['imgprefix']}/themes/css/default/logo.png";

$image->link = "{$INI['system']['sitename']}";

$image->description = "Feed provided by gripsell.com";

$rss->image = $image;

if ($deals) {
    
    
    
    $item = new FeedItem();
    
    
    
     $item->title = $deals['title'];
    
    
    
     $item->link = $INI['system']['wwwprefix'] . '/deals.php?id=' . $deals['id'];
    
    
    
     $item->description = $deals['summary'] . "<br /><img src='" . deals_image($deals['image']) . "'/>" . $deals['systemreview'];
    
    
    
     $item->date = $deals['create_time'];
    
    
    
     $item->source = $INI['system']['wwwprefix'];
    
    
    
     $item->author = $city['name'];
    
    
    
     $rss->addItem($item);
    
    
    
    } 

$rss->outputFeed("RSS2.0");

echo $ob_content;

?>