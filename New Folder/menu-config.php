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

// ##############################
// Edit only if you know what you are doing.
// ##############################

function current_frontend()
{
    
     global $INI;
    
     if (abs(intval($INI['system']['showwp']))) {
        
        $a = array(
            
            '/index.php' => TEXT_EN_DEAL_OF_THE_DAY_EN,
            
             '/insta' => TEXT_EN_INSTA_DEALS_EN,
            
             '/zone.php' => TEXT_EN_DEAL_ZONE_EN,
            
             '/upcoming.php' => TEXT_EN_UPCOMING_DEALS_EN,
            
             '/tour/index.php' => TEXT_EN_HOW_IT_WORKS_EN,
            
            // '/subscribe.php' => TEXT_EN_SUBSCRIBE_EN,
             '/business/index.php' => TEXT_EN_BUSINESS_EN,
            
            );
        
         } else {
        
        
        
        if (abs(intval($INI['display']['showinsta']))) {
            
            $a = array(
                
                '/index.php' => TEXT_EN_DEAL_OF_THE_DAY_EN,
                
                 '/insta' => TEXT_EN_INSTA_DEALS_EN,
                
                 '/zone.php' => TEXT_EN_DEAL_ZONE_EN,
                
                 '/upcoming.php' => TEXT_EN_UPCOMING_DEALS_EN,
                
                 '/tour/index.php' => TEXT_EN_HOW_IT_WORKS_EN,
                
                 '/dealsmap.php' => TEXT_EN_DEALSMAP_EN,
                
                 '/business/index.php' => TEXT_EN_BUSINESS_EN,
                
                );
            
             } else {
            
            $a = array(
                
                '/index.php' => TEXT_EN_DEAL_OF_THE_DAY_EN,
                
                 '/zone.php' => TEXT_EN_DEAL_ZONE_EN,
                
                 '/upcoming.php' => TEXT_EN_UPCOMING_DEALS_EN,
                
                 '/tour/index.php' => TEXT_EN_HOW_IT_WORKS_EN,
                
                 '/dealsmap.php' => TEXT_EN_DEALSMAP_EN,
                
                 '/business/index.php' => TEXT_EN_BUSINESS_EN,
                
                );
            
             } 
        
        } 
    
    
    
    if (!abs(intval($INI['display']['pp']))) unset($a['/business/index.php']);
    
    
    
     // if (abs(intval($INI['system']['forum']))) {
    // unset($a['/subscribe.php']);
    // $a['/forum/index.php'] = TEXT_EN_DISCUSS_EN;
    // }
    $r = $_SERVER['REQUEST_URI'];
    
     if (preg_match('#/deals#', $r)) $l = '/deals/index.php';
    
     elseif (preg_match('#/help#', $r)) $l = '/tour/index.php';
    
     elseif (preg_match('#/subscribe#', $r)) $l = '/subscribe.php';
    
     else $l = '/index.php';
    
     return current_link_lang(null, $a);
    
     } 

function current_backend()
{
    
     global $INI;
    
    
    
     if (abs(intval($INI['display']['showinsta']))) {
        
        $a = array(
            
            '/manage/misc/index.php' => 'Home',
            
             '/manage/deal/index.php' => 'Deals',
            
             '/manage/insta/index.php' => '<b style="color:#ffcc00">' . TEXT_EN_INSTA_DEALS_EN . '</b>',
            
             '/manage/order/index.php' => 'Orders',
            
             '/manage/finance/index.php' => 'Financials',
            
             '/manage/coupon/index.php' => 'Coupons',
            
             '/manage/user/index.php' => 'Users',
            
             '/manage/partner/index.php' => 'Partners',
            
             '/manage/market/index.php' => 'Marketing',
            
             '/manage/cities/index.php' => 'Cities',
            
             '/manage/category/index.php' => 'Categories',
            
             '/manage/system/index.php' => 'System',
            
            );
        
         } else {
        
        $a = array(
            
            '/manage/misc/index.php' => 'Home',
            
             '/manage/deal/index.php' => 'Deals',
            
             // '/manage/insta/index.php' => '<b style="color:#ffcc00">'.TEXT_EN_INSTA_DEALS_EN.'</b>',
            '/manage/order/index.php' => 'Orders',
            
             '/manage/finance/index.php' => 'Financials',
            
             '/manage/coupon/index.php' => 'Coupons',
            
             '/manage/user/index.php' => 'Users',
            
             '/manage/partner/index.php' => 'Partners',
            
             '/manage/market/index.php' => 'Marketing',
            
             '/manage/cities/index.php' => 'Cities',
            
             '/manage/category/index.php' => 'Categories',
            
             '/manage/system/index.php' => 'System',
            
            );
        
         } 
    
    $r = $_SERVER['REQUEST_URI'];
    
     if (preg_match('#/manage/(\w+)/#', $r, $m)) {
        
        $l = "/manage/{$m[1]}/index.php";
        
         } else $l = '/manage/misc/index.php';
    
     return current_link($l, $a);
    
    } 

function current_business_bk()
{
    
     global $INI;
    
     $a = array(
        
        '/business/index.php' => 'Home',
        
         '/manage/deal/index.php' => 'Deals',
        
         '/manage/insta/index.php' => 'Insta Deals',
        
         '/business/coupon.php' => 'Coupons',
        
         '/business/createagent.php' => 'Add Retailer',
        
         '/business/agent.php' => 'Manage Retailers',
        
         '/business/settings.php' => 'Manage Profile',
        
         '/business/viewcommission.php' => 'View Commission',
        
        );
    
     $r = $_SERVER['REQUEST_URI'];
    
     if (preg_match('#/business/coupon#', $r)) $l = '/business/coupon.php';
    
     elseif (preg_match('#/manage/deal/create#', $r)) $l = '/manage/deal/create.php';
    
     elseif (preg_match('#/manage/deal/index#', $r)) $l = '/manage/deal/index.php';
     elseif (preg_match('#/manage/insta/index#', $r)) $l = '/manage/insta/index.php';
    
     elseif (preg_match('#/business/settings#', $r)) $l = '/business/settings.php';
    
     elseif (preg_match('#/business/agent#', $r)) $l = '/business/agent.php';
    
     elseif (preg_match('#/business/createagent#', $r)) $l = '/business/createagent.php';
    
     elseif (preg_match('#/business/viewcommission#', $r)) $l = '/business/viewcommission.php';
    
     else $l = '/business/index.php';
    
     return current_link($l, $a);
    
    }
	
	
	function current_business($mod='')
{
	
	
 if($mod=='deal')
  {
	 $deal='class="activated"';   
	  }
	  else if($mod=='insta')
	  {
		$insta='class="activated"';  
		  }
		 
		  else if($mod=='coupons')
	  {
		  $coupons='class="activated"';  
		  }
		 
		  else
		  {
			// $selected='class="not_activated"'; 
			  }
		  
		  
   
  
     $html = '<nav>
<div class="nav_heading">Navigation</div>
			<ul id="menu" class="adnavmenu">';

              $html .= '<li><a href="/business/index.php" ><img src="/themes/adnav/images/icons/16/fugue/home--arrow.png" alt=""/> Home<!--<span>--><!-- arrow --><!--</span>--></a>              

                    	
                   

                </li>';

                $html .= ' <li ><a href="/manage/deal/index.php" ><img src="/themes/adnav/images/icons/16/fugue/shopping-basket.png" alt=""/> Deals<!--<span>--><!-- arrow --><!--</span>--></a>

                   

                        <ul '.$deal.'>

                            <li class="shopping-basket--plus"><a href="/manage/deal/create.php">Create Deal</a><span></span></li>

                            <li class="award_star_gold_2"><a href="/manage/deal/index.php?action=do&show=current">Live Deals</a><span></span></li>

                            <li class="time_go"><a href="/manage/deal/index.php?action=do&show=approved">Approved Deals</a><span></span></li>

                            <li class="page_white_delete"><a href="/manage/deal/index.php?action=do&show=canceled">Canceled Deals</a><span></span></li>

                            <li class="pencil_go"><a href="/manage/deal/index.php?action=do&show=draft">Draft Deals</a><span></span></li>

                            <li class="no_image"><a href="/manage/deal/index.php?action=do&show=failed">Failed Deals</a><span></span></li>

                            <li class="package_green"><a href="/manage/deal/index.php?action=do&show=pending">Pending Deals</a><span></span></li>

                            <li class="mouse_select_right"><a href="/manage/deal/index.php?action=do&show=returned">Returned Deals</a><span></span></li>

                            <li class="medal_bronze_2"><a href="/manage/deal/index.php?action=do&show=tipped">Tipped Deals</a><span></span></li>

                            <li class="large_tiles"><a href="/manage/deal/index.php?action=do&show=all	">Show All</a><span></span></li>

                        </ul>

 				

                </li>';

                $html .= ' <li><a href="/manage/insta/index.php" ><b style="color:#f00"><img src="/themes/adnav/images/icons/16/fugue/trophy.png" alt=""/> Insta</b><!--<span>--><!-- arrow --><!--</span>--></a>

                	

						<ul '.$insta.'>

                        	<li class="trophy--plus"><a href="/manage/insta/create.php">Create Insta</a><span></span></li>

                            <li class="accept"><a href="/manage/insta/index.php?action=do&show=current">Live Insta</a><span></span></li>

                            <li class="transmit_go"><a href="/manage/insta/index.php?action=do&show=approved">Approved Insta</a><span></span></li>

                            <li class="support"><a href="/manage/insta/index.php?action=do&show=closed">Closed Insta</a><span></span></li>

                            <li class="construction"><a href="/manage/insta/index.php?action=do&show=draft">Draft Insta</a><span></span></li>

                            <li class="table_insert"><a href="/manage/insta/index.php?action=do&show=pending">Pending Insta</a><span></span></li>

                            <li class="control_pause_record"><a href="/manage/insta/index.php?action=do&show=returned">Returned Insta</a><span></span></li>

                            <li class="color_swatch"><a href="/manage/insta/index.php?action=do&show=all	">Show All</a><span></span></li>

						</ul>

					
                </li>';

              

               $html .= '  <li><a href="/manage/coupon/index.php"><img src="/themes/adnav/images/icons/16/fugue/ticket--pencil.png" alt=""/> Coupons<!--<span>--><!-- arrow --><!--</span>--></a>

                

                    	<ul '.$coupons.'>

                        	<li class="ticket--arrow"><a href="/business/coupon.php?show=valid">Valid Coupons</a><span></span></li>

                            <li class="ticket--minus"><a href="/business/coupon.php?show=used">Used Coupons</a><span></span></li>

                            <li class="ticket--exclamation"><a href="/business/coupon.php?show=expired">Expired Coupons</a><span></span></li>

                            <li class="ticket--plus"><a href="/business/coupon.php?show=all">All Coupons</a><span></span></li>

                           

						</ul>

                  </li>';
				  
				   $html .= '  <li><a href="/business/createagent.php"><img src="/themes/adnav/images/icons/16/fugue/inbox-image.png" alt=""/> Add Retailer</a>

                </li>';
				
				 $html .= '  <li><a href="/business/agent.php"><img src="/themes/adnav/images/icons/16/fugue/newspaper--pencil.png" alt=""/> Manage Retailer</a>

                </li>';
				
				 $html .= '  <li><a href="/business/settings.php"><img src="/themes/adnav/images/icons/16/fugue/map-pin.png" alt=""/> Manage Profile</a>

                </li>';
				
				 $html .= '  <li><a href="/business/viewcommission.php"><img src="/themes/adnav/images/icons/16/fugue/television.png" alt=""/> View Commission</a>

                </li>';

             

		   $html .= '  </ul>

		</nav>

		';
    
     return $html;
    
    }  

function current_link1($link, $links, $span = false)
{
    
     $html = '';
    
     $span = $span ? '<span></span>' : '';
     $i = 1;
     foreach($links AS $l => $n) {
        $css = "currentdeal" . $i;
         if (trim($l, '/') == trim($link, '/')) {
            
            $html .= "<li class=\"current\"><a href=\"{$l}\">{$n}</a>{$span}</li>";
            
             } 
        
        else $html .= "<li class='{$css}'><a href=\"{$l}\">{$n}</a>{$span}</li>";
        $i++;
         } 
    
    return $html;
    
    } 
function current_agent_bk()
{
    
     global $INI;
    
     $a = array(
        
        '/business/index.php' => 'Home',
        
         '/business/coupon.php' => 'Manage ' . $INI['system']['couponname'],
        
        );
    
     $r = $_SERVER['REQUEST_URI'];
    
     if (preg_match('#/business/coupon#', $r)) $l = '/business/coupon.php';
    
     else $l = '/business/index.php';
    
     return current_link($l, $a);
    
    } 
	
function current_agent()
{	

 $html = '<nav>
<div class="nav_heading">Navigation</div>
			<ul id="menu" class="adnavmenu">';


	//  $html .= '  <li><a href="/business/index.php" ><img src="/themes/adnav/images/icons/16/fugue/inbox-image.png" alt=""/> Home</a>

                //</li>';
				
				 $html .= '  <li><a href="/business/coupon.php"><img src="/themes/adnav/images/icons/16/fugue/newspaper--pencil.png" alt=""/> Manage Coupon</a>
				 
				 
				 <ul '.$coupons.'>

                        	<li class="ticket--arrow"><a href="/business/coupon.php?show=valid">Valid Coupons</a><span></span></li>

                            <li class="ticket--minus"><a href="/business/coupon.php?show=used">Used Coupons</a><span></span></li>

                            <li class="ticket--exclamation"><a href="/business/coupon.php?show=expired">Expired Coupons</a><span></span></li>

                            <li class="ticket--plus"><a href="/business/coupon.php?show=all">All Coupons</a><span></span></li>

                           

						</ul>

				 
				 

                </li>';
				
				
	  $html .= '  </ul>

		</nav>

		';
    
     return $html;
}
// function current_forum($selector='index') {
// global $city;
// $a = array(
// '/forum/index.php' => TEXT_EN_ALL_DISCUSS_EN,
// '/forum/city.php' => TEXT_EN_DISCUSS_CITY_DEALS_EN,
// '/forum/public.php' => TEXT_EN_PUBLIC_FORUM_EN,
// );
// if (!$city) unset($a['/forum/city.php']);
// $l = "/forum/{$selector}.php";
// return current_link_lang($l, $a, true);
// }

function current_city($cename, $citys)
{
    
     $link = "/city.php?ename={$cename}";
    
     $links = array();
    
     $daytime = time();
    
     foreach($citys as $city) {
        
        $deals = DB::LimitQuery('deals', array(
                
                'condition' => array(
                    
                    "(city_id = '0' OR find_in_set({$city['id']},city_id))",
                    
                     'stage' => array('1-featured', 'approved'),
                    
                     "begin_time <  {$daytime}",
                    
                     "end_time >  {$daytime}",
                    
                    ),
                
                ));
        
         $deals_count = count($deals);
        
         $links["/city.php?ename={$city['ename']}"] = $city['name'] . '[' . $deals_count . ']';
        
         } 
    
    return current_link($link, $links);
    
    } 

function current_coupon_sub($selector = 'index')
{
    
     $selector = $selector ? $selector : 'index';
    
     $a = array(
        
        '/manage/coupons/index.php' => 'not used',
        
         '/manage/coupons/consume.php' => 'used',
        
         '/manage/coupons/expire.php' => 'expired',
        
        );
    
     $l = "/manage/coupons/{$selector}.php";
    
     return current_link($l, $a);
    
    } 

function current_account($selector = '/account/settings.php')
{
    
     global $INI;
    
     $a = array(
        
        '/account/order/index.php' => TEXT_EN_MY_ORDERS_EN,
        
         '/manage/coupons/index.php' => TEXT_EN_MY_COUPONS_EN,
        
         '/credit/index.php' => TEXT_EN_BALANCE_EN,
        
         '/account/settings.php' => TEXT_EN_ACCOUNT_SETTINGS_EN,
        
        );
    
     return current_link_lang($selector, $a, true);
    
    } 

function current_about($selector = 'us')
{
    
     global $INI;
    
     $a = array(
        
        '/about/us.php' => TEXT_EN_ABOUT_US_EN,
        
         '/about/contact.php' => TEXT_EN_CONTACT_US_EN,
        
         '/about/job.php' => TEXT_EN_WORK_WITH_US_EN,
        
         '/about/privacy.php' => TEXT_EN_PRIVACY_POLICY_EN,
        
         '/about/terms.php' => TEXT_EN_TERMS_OF_SERVICE_EN,
        
        );
    
     $l = "/about/{$selector}.php";
    
     return current_link_lang($l, $a, true);
    
    } 

function current_help($selector = 'faqs')
{
    
     global $INI;
    
     $a = array(
        
        '/tour/index.php' => TEXT_EN_HOW_IT_WORKS_EN,
        
         '/faqs.php' => TEXT_EN_FAQ_EN,
        
         // '/TGS.php' => TEXT_EN_BLOG_EN, //Deprecating
        
        
        );
    
     $l = "/{$selector}.php";
    
     return current_link_lang($l, $a, true);
    
    } 

function current_order_index($selector = 'index')
{
    
     $selector = $selector ? $selector : 'index';
    
     $a = array(
        
        '/account/order/index.php?s=index' => TEXT_EN_ALL_EN,
        
         '/account/order/index.php?s=unpay' => TEXT_EN_UNPAID_EN,
        
         '/account/order/index.php?s=pay' => TEXT_EN_PAID_EN,
        
        );
    
     $l = "/account/order/index.php?s={$selector}";
    
     return current_link_lang($l, $a);
    
    } 

function current_link($link, $links, $span = false)
{
    
     $html = '';
    
     $span = $span ? '<span></span>' : '';
    
     foreach($links AS $l => $n) {
        
        if (trim($l, '/') == trim($link, '/')) {
            
            $html .= "<li class=\"current\"><a href=\"{$l}\">{$n}</a>{$span}</li>";
            
             } 
        
        else $html .= "<li><a href=\"{$l}\">{$n}</a>{$span}</li>";
        
         } 
    
    return $html;
    
    } 

function admin_navbar($mod='home')
{
	
	
  if($mod=='home')
  {
   $home='class="activated"';  
  }
  else if($mod=='deal')
  {
	 $deal='class="activated"';   
	  }
	  else if($mod=='insta')
	  {
		$insta='class="activated"';  
		  }
		  else if($mod=='orders')
	  {
		  $orders='class="activated"';  
		  }
		  else if($mod=='financials')
	  {
		  $financials='class="activated"';  
		  }
		  else if($mod=='coupons')
	  {
		  $coupons='class="activated"';  
		  }
		  else if($mod=='users')
	  {
		  $users='class="activated"';  
		  }
		  else if($mod=='marketing')
	  {
		  $marketing='class="activated"';  
		  }
		  else if($mod=='cities')
	  {
		  $cities='class="activated"';  
		  }
		  else if($mod=='categories')
	  {
		  $categories='class="activated"';  
		  }
		  else if($mod=='system')
	  {
		 $system='class="activated"';  
		  }
		  
		  else
		  {
			// $selected='class="not_activated"'; 
			  }
		  
		  
   
  
     $html = '<nav>
<div class="nav_heading">Navigation</div>
			<ul id="menu" class="adnavmenu">';

              $html .= '<li><a href="/manage/misc/index.php" ><img src="/themes/adnav/images/icons/16/fugue/home--arrow.png" alt=""/> Home<!--<span>--><!-- arrow --><!--</span>--></a>

                

                    	<ul '.$home.'>

                        	<li class="monitor_window"><a href="/manage/misc/index.php">Admin Home</a><span></span></li>

                            <li class="hslider"><a href="/manage/system/prerelease.php">Pre-release Setup</a><span></span></li>

                            <!--<li class="elements"><a href="/manage/finance/index.php">Finance Record</a><span></span></li>-->

                            <li class="question-frame"><a href="/manage/misc/ask.php">Q &amp; A</a><span></span></li>

                            <li class="group_gear"><a href="/manage/misc/feedback.php">Feedback</a><span></span></li>

                            <li class="email_to_friend"><a href="/manage/misc/subscribe.php">Subscribers List</a><span></span></li>

                            <li class="cash_register"><a href="/manage/misc/charity.php">Charity Setup</a><span></span></li>

                            <li class="setting_tools"><a href="/manage/misc/settings.php">Account Settings</a><span></span></li>

						</ul>

                   

                </li>';

                $html .= ' <li ><a href="/manage/deal/index.php" ><img src="/themes/adnav/images/icons/16/fugue/shopping-basket.png" alt=""/> Deals<!--<span>--><!-- arrow --><!--</span>--></a>

                   

                        <ul '.$deal.'>

                            <li class="shopping-basket--plus"><a href="/manage/deal/create.php">Create Deal</a><span></span></li>

                            <li class="award_star_gold_2"><a href="/manage/deal/index.php?action=do&show=current">Live Deals</a><span></span></li>

                            <li class="time_go"><a href="/manage/deal/index.php?action=do&show=approved">Approved Deals</a><span></span></li>

                            <li class="page_white_delete"><a href="/manage/deal/index.php?action=do&show=canceled">Canceled Deals</a><span></span></li>

                            <li class="pencil_go"><a href="/manage/deal/index.php?action=do&show=draft">Draft Deals</a><span></span></li>

                            <li class="no_image"><a href="/manage/deal/index.php?action=do&show=failed">Failed Deals</a><span></span></li>

                            <li class="package_green"><a href="/manage/deal/index.php?action=do&show=pending">Pending Deals</a><span></span></li>

                            <li class="mouse_select_right"><a href="/manage/deal/index.php?action=do&show=returned">Returned Deals</a><span></span></li>

                            <li class="medal_bronze_2"><a href="/manage/deal/index.php?action=do&show=tipped">Tipped Deals</a><span></span></li>

                            <li class="large_tiles"><a href="/manage/deal/index.php?action=do&show=all	">Show All</a><span></span></li>

                        </ul>

 				

                </li>';

                $html .= ' <li><a href="/manage/insta/index.php" ><b style="color:#f00"><img src="/themes/adnav/images/icons/16/fugue/trophy.png" alt=""/> Insta</b><!--<span>--><!-- arrow --><!--</span>--></a>

                	

						<ul '.$insta.'>

                        	<li class="trophy--plus"><a href="/manage/insta/create.php">Create Insta</a><span></span></li>

                            <li class="accept"><a href="/manage/insta/index.php?action=do&show=current">Live Insta</a><span></span></li>

                            <li class="transmit_go"><a href="/manage/insta/index.php?action=do&show=approved">Approved Insta</a><span></span></li>

                            <li class="support"><a href="/manage/insta/index.php?action=do&show=closed">Closed Insta</a><span></span></li>

                            <li class="construction"><a href="/manage/insta/index.php?action=do&show=draft">Draft Insta</a><span></span></li>

                            <li class="table_insert"><a href="/manage/insta/index.php?action=do&show=pending">Pending Insta</a><span></span></li>

                            <li class="control_pause_record"><a href="/manage/insta/index.php?action=do&show=returned">Returned Insta</a><span></span></li>

                            <li class="color_swatch"><a href="/manage/insta/index.php?action=do&show=all	">Show All</a><span></span></li>

						</ul>

					
                </li>';

              $html .= ' <li><a href="/manage/order/index.php"><img src="/themes/adnav/images/icons/16/fugue/bookmark-book-open.png" alt=""/> Orders<!--<span>--><!-- arrow --><!--</span>--></a>

                  

                        <ul '.$orders.'>

                            <li class="cart"><a href="/manage/order/index.php">Current Order</a><span></span></li>

                            <li class="cart_go"><a href="/manage/order/pay.php">Paid Order</a><span></span></li>

                            <li class="cart_error"><a href="/manage/order/unpay.php">Unpaid Order</a><span></span></li>

                            <li class="card_money"><a href="/manage/commission/index.php">Commission</a><span></span></li></ul>

                   

                </li>';

              $html .= '  <li><a href="/manage/finance/index.php"><img src="/themes/adnav/images/icons/16/fugue/money-coin.png" alt=""/> Financials<!--<span>--><!-- arrow --><!--</span>--></a>

                	

                    	<ul '.$financials.'>

                            <!--<li class="table_money"><a href="/manage/finance/index.php">Finance Record</a></li>-->

                            <li class="money_in_envelope"><a href="/manage/finance/invite.php?s=index">Invitation Receivables</a></li>

                            <li class="money_bag"><a href="/manage/finance/invite.php?s=record">Invitation Rebate</a></li>

                            <li class="money_add"><a href="/manage/finance/index.php?s=store">Offline Topup</a></li>

                            <li class="money_dollar"><a href="/manage/finance/index.php?s=charge">Online Topup</a></li>

                            <li class="money_delete"><a href="/manage/finance/index.php?s=withdraw">Withdrawals</a></li>

                            <li class="cash_stack"><a href="/manage/finance/index.php?s=cash">Cash Payments</a></li>

                            <li class="cash_terminal"><a href="/manage/finance/index.php?s=refund">Refunds</a></li>

                        </ul>

                  

                </li>';

               $html .= '  <li><a href="/manage/coupon/index.php"><img src="/themes/adnav/images/icons/16/fugue/ticket--pencil.png" alt=""/> Coupons<!--<span>--><!-- arrow --><!--</span>--></a>

                

                    	<ul '.$coupons.'>

                        	<li class="ticket--arrow"><a href="/manage/coupon/index.php">Not used</a><span></span></li>

                            <li class="ticket--minus"><a href="/manage/coupon/consume.php">Used</a><span></span></li>

                            <li class="ticket--exclamation"><a href="/manage/coupon/expire.php">Expired</a><span></span></li>

                            <li class="ticket--plus"><a href="/manage/coupon/card.php">Current Vouchers</a><span></span></li>

                            <li class="ticket--pencil"><a href="/manage/coupon/cardcreate.php">Create Voucher</a><span></span></li>

						</ul>

                   

                </li>';

              $html .= '<li><a href="/manage/user/index.php"><img src="/themes/adnav/images/icons/16/fugue/users--pencil.png" alt=""/> Users<!--<span>--><!-- arrow --><!--</span>--></a>

                    	

                            <ul '.$users.'>

                                <li class="reseller_programm"><a href="/manage/user/index.php">User List</a><span></span></li>

                                <li class="reseller_account_template"><a href="/manage/user/manager.php">Admin List</a><span></span></li>

                            </ul>

                            <ul '.$users.'>

                                <li class="drive_user"><a href="/manage/partner/index.php">Partners</a><span></span></li>

                                <li class="user_go"><a href="/manage/partner/create.php">New Partner</a><span></span></li>

                            </ul>

						

                </li>';

              $html .= '   <li><a href="/manage/market/index.php"><img src="/themes/adnav/images/icons/16/fugue/newspaper--pencil.png" alt=""/> Marketing<!--<span>--><!-- arrow --><!--</span>--></a>

                	

                    	<ul '.$marketing.'>

                        	<li class="contact_email"><a href="/manage/market/index.php">Send Email</a><span></span></li>

                            <li class="download"><a href="/manage/market/down.php">Download Data</a><span></span></li>

						</ul>

                   

                </li>';

              $html .= '   <li><a href="/manage/cities/index.php"><img src="/themes/adnav/images/icons/16/fugue/map-pin.png" alt=""/> Cities<!--<span>--><!-- arrow --><!--</span>--></a>

                	

                    	<ul '.$cities.'>

                        	<li class="map_edit"><a href="/manage/cities/index.php?zone=city">Cities</a><span></span></li>

                            <li class="google_map"><a href="/manage/cities/index.php?zone=group">Country</a><span></span></li>

						</ul>

                   

                </li>';

               $html .= '  <li><a href="/manage/category/index.php" '.$categories.'><img src="/themes/adnav/images/icons/16/fugue/inbox-image.png" alt=""/> Categories</a>

                </li>';

              $html .= '   <li><a href="/manage/system/index.php"><img src="/themes/adnav/images/icons/16/fugue/television.png" alt=""/> System<!--<span>--><!-- arrow --><!--</span>--></a>

                	

                    	<ul '.$system.'>

                        	<li class="dns_setting"><a href="/manage/system/index.php">General Settings</a><span></span></li>

                            <li class="television"><a href="/manage/system/display.php">Display Settings</a><span></span></li>

                            <li class="sound_add"><a href="/manage/system/bulletin.php">Announcement</a><span></span></li>

                            <li class="money"><a href="/manage/system/pay.php">Payment Gateway</a><span></span></li>

                            <li class="email_edit"><a href="/manage/system/email.php">Setup Email</a><span></span></li>

                            <li class="phone"><a href="/manage/system/sms.php">Setup SMS</a><span></span></li>

                            <li class="transform_shear"><a href="/manage/system/language.php">Manage Languages</a><span></span></li>

                            <li class="transform_crop_resize"><a href="/manage/system/translate.php">Manage Translations</a><span></span></li>

                            <li class="pencil"><a href="/manage/system/page.php">Content Management</a><span></span></li>

                            <li class="server_stanchion"><a href="/manage/system/cache.php">Cache Config</a><span></span></li>

                            <li class="setting_tools"><a href="/manage/system/optimize.php">Optimize System</a><span></span></li>

                            <li class="server_database"><a href="/manage/system/backup.php">Backup Data</a><span></span></li>

                            <li class="server_go"><a href="/manage/system/restore.php">Restore Data</a><span></span></li>

						</ul>

                    

                </li>';

		   $html .= '  </ul>

		</nav>

		';
    
     return $html;
    
    } 

function current_link_lang($link, $links, $span = false)
{
    
     $html = '';
    
     $span = $span ? '<span></span>' : '';
    
     foreach($links AS $l => $n) {
        
        if (trim($l, '/') == trim($link, '/')) {
            
            echo "<li class=\"current\"><a href=\"" . $l . "\">";
            
             echo __($n);
            
             echo "</a>" . $span . "</li>";
            
             } 
        
        else {
            
            echo "<li><a href=\"" . $l . "\">";
            
             echo __($n);
            
             echo "</a>" . $span . "</li>";
            
             } 
        
        } 
    
    return $html;
    
    } 

/**
 * manage current
 */

function mcurrent_misc($selector = null)
{
    
     $a = array(
        
        '/manage/misc/index.php' => 'Dashboard',
        
         '/manage/system/prerelease.php' => '<b>Pre-release Setup</b>',
        
         // '/manage/finance/index.php' => '<b>Finance Record</b>',
        '/manage/misc/ask.php' => 'Q & A',
        
         '/manage/misc/feedback.php' => 'Feedback',
        
         '/manage/misc/subscribe.php' => 'Subscribers List',
        
         '/manage/misc/charity.php' => 'Charity Setup',
        
         '/manage/misc/settings.php' => '<span style="color:#cc0000;">Account Settings</span>',
        
        );
    
     $l = "/manage/misc/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_misc_money($selector = null)
{
    
     $selector = $selector ? $selector : 'store';
    
     $a = array(
        
        // '/manage/finance/index.php' => '<b>Finance Record</b>',
        '/manage/finance/invite.php?s=index' => 'Invitation Receivables',
        
         '/manage/finance/invite.php?s=record' => 'Invitation Rebate',
        
         '/manage/finance/index.php?s=store' => 'Offline Topup',
        
         '/manage/finance/index.php?s=charge' => 'Online Topup',
        
         '/manage/finance/index.php?s=withdraw' => 'Withdrawals',
        
         '/manage/finance/index.php?s=cash' => 'Cash Payments',
        
         '/manage/finance/index.php?s=refund' => 'Refunds',
        
        );
    
     $l = "/manage/finance/index.php?s={$selector}";
    
     return current_link($l, $a);
    
    } 

function mcurrent_misc_invite($selector = null)
{
    
     $selector = $selector ? $selector : 'index';
    
     $a = array(
        
        '/manage/misc/invite.php?s=index' => 'Invitation',
        
         '/manage/misc/invite.php?s=record' => 'Rebate',
        
        );
    
     $l = "/manage/misc/invite.php?s={$selector}";
    
     return current_link($l, $a);
    
    } 

function mcurrent_order($selector = null)
{
    
     $a = array(
        
        '/manage/order/index.php' => 'Current Order',
        
         '/manage/order/pay.php' => 'Paid Order',
        
         '/manage/order/unpay.php' => 'Unpaid Order',
        
         '/manage/commission/index.php' => 'Commission',
        
        );
    
     $l = "/manage/order/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_user($selector = null)
{
    
     $a = array(
        
        '/manage/user/index.php' => 'User List',
        
         '/manage/user/manager.php' => 'Admin List',
        
        );
    
     $l = "/manage/user/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_deals($selector = null)
{
    
     $a = array(
        
        '/manage/deal/create.php' => 'Create Deal',
        
         '/manage/deal/index.php?action=do&show=current' => 'Live Deals',
        
         // '/manage/deal/success.php' => 'Tipped Deals',
        // '/manage/deal/failure.php' => 'Failed Deals',
        '/manage/deal/index.php?action=do&show=approved' => 'Approved Deals',
        
         '/manage/deal/index.php?action=do&show=canceled' => 'Canceled Deals',
        
         '/manage/deal/index.php?action=do&show=draft' => 'Draft Deals',
        
         '/manage/deal/index.php?action=do&show=failed' => 'Failed Deals',
        
         '/manage/deal/index.php?action=do&show=pending' => 'Pending Deals',
        
         '/manage/deal/index.php?action=do&show=returned' => 'Returned Deals',
        
         '/manage/deal/index.php?action=do&show=tipped' => 'Tipped Deals',
        
         '/manage/deal/index.php?action=do&show=all	' => 'Show All'
        
        );
    
     $l = "/manage/deal/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function bcurrent_deals($selector = null)
{
    
     $a = array(
        
        '/manage/deal/create.php' => 'Create Deal',
        
         '/manage/deal/index.php?action=do&show=current' => 'Live Deals',
        
         '/manage/deal/index.php?action=do&show=approved' => 'Approved Deals',
        
         '/manage/deal/index.php?action=do&show=canceled' => 'Canceled Deals',
        
         '/manage/deal/index.php?action=do&show=draft' => 'Draft Deals',
        
         '/manage/deal/index.php?action=do&show=failed' => 'Failed Deals',
        
         '/manage/deal/index.php?action=do&show=pending' => 'Pending Deals',
        
         '/manage/deal/index.php?action=do&show=returned' => 'Returned Deals',
        
         '/manage/deal/index.php?action=do&show=tipped' => 'Tipped Deals',
        
         '/manage/deal/index.php?action=do&show=all	' => 'Show All',
        
        );
    
     $l = "/manage/deal/{$selector}.php";
    
     return current_link1($l, $a, true);
    
    } 

function minsta_deals($selector = null)
{
    
     $a = array(
        
        '/manage/insta/create.php' => 'Create Insta',
        
         '/manage/insta/index.php?action=do&show=current' => 'Live Insta',
        
         '/manage/insta/index.php?action=do&show=approved' => 'Approved Insta',
        
         '/manage/insta/index.php?action=do&show=closed' => 'Closed Insta',
        
         '/manage/insta/index.php?action=do&show=draft' => 'Draft Insta',
        
         '/manage/insta/index.php?action=do&show=pending' => 'Pending Insta',
        
         '/manage/insta/index.php?action=do&show=returned' => 'Returned Insta',
        
         '/manage/insta/index.php?action=do&show=all	' => 'Show All'
        
        );
    
     $l = "/manage/insta/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function binsta_deals($selector = null)
{
    
     $a = array(
        
        '/manage/insta/create.php' => 'Create Deal',
        
         '/manage/insta/index.php?action=do&show=current' => 'Live Insta',
        
         '/manage/insta/index.php?action=do&show=approved' => 'Approved Insta',
        
         '/manage/insta/index.php?action=do&show=closed' => 'Closed Insta',
        
         '/manage/insta/index.php?action=do&show=draft' => 'Draft Insta',
        
         '/manage/insta/index.php?action=do&show=pending' => 'Pending Insta',
        
         '/manage/insta/index.php?action=do&show=returned' => 'Returned Insta',
        
         '/manage/insta/index.php?action=do&show=all	' => 'Show All',
        
        );
    
     $l = "/manage/insta/{$selector}.php";
    
     return current_link1($l, $a, true);
    
    } 

function mcurrent_feedback($selector = null)
{
    
     $a = array(
        
        '/manage/feedback/index.php' => 'View all',
        
        );
    
     $l = "/manage/feedback/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_coupon($selector = null)
{
    
     $a = array(
        
        '/manage/coupon/index.php' => 'Not used',
        
         '/manage/coupon/consume.php' => 'Used',
        
         '/manage/coupon/expire.php' => 'Expired',
        
         '/manage/coupon/card.php' => 'Current Vouchers',
        
         '/manage/coupon/cardcreate.php' => 'Create Voucher',
        
        );
    
     $l = "/manage/coupon/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_category($selector = null)
{
    
     $zones = get_zones();
    
     $a = array();
    
     foreach($zones AS $z => $o) {
        
        $a['/manage/cities/index.php?zone=' . $z] = $o;
        
         } 
    
    $l = "/manage/cities/index.php?zone={$selector}";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_partner($selector = null)
{
    
     $a = array(
        
        '/manage/partner/index.php' => 'Partners',
        
         '/manage/partner/create.php' => 'New Partner',
        
        );
    
     $l = "/manage/partner/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_market($selector = null)
{
    
     $a = array(
        
        '/manage/market/index.php' => 'Send Email',
        
         '/manage/market/down.php' => 'Download Data',
        
        );
    
     $l = "/manage/market/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_market_down($selector = null)
{
    
     $a = array(
        
        '/manage/market/down.php' => 'Contact No.',
        
         '/manage/market/downemail.php' => 'Email',
        
         '/manage/market/downorder.php' => 'Orders',
        
         '/manage/market/downcoupon.php' => 'Coupons',
        
         '/manage/market/downuser.php' => 'User Info',
        
         '/manage/market/presubscriber.php' => 'Presubscribe',
        
        );
    
     $l = "/manage/market/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

function mcurrent_system($selector = null)
{
    
     $a = array(
        
        '/manage/system/index.php' => 'General Settings',
        
         '/manage/system/display.php' => '<b>Display Settings</b>',
        
         '/manage/system/bulletin.php' => 'Announcement',
        
         '/manage/system/pay.php' => 'Payment Gateway',
        
         '/manage/system/email.php' => 'Setup Email',
        
         '/manage/system/sms.php' => 'Setup SMS',
        
         '/manage/system/language.php' => '<b>Manage Languages</b>',
        
         '/manage/system/translate.php' => '<b>Manage Translations</b>',
        
         '/manage/system/page.php' => 'Content Management',
        
         '/manage/system/cache.php' => 'Cache Config',
        
         '/manage/system/optimize.php' => 'Optimize System',
        
         '/manage/system/backup.php' => 'Backup Data',
        
         '/manage/system/restore.php' => 'Restore Data',
        
         '/manage/system/prerelease.php' => '<b>Pre-release Setup</b>',
        
        );
    
     $l = "/manage/system/{$selector}.php";
    
     return current_link($l, $a, true);
    
    } 

?>