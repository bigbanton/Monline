<?php
/**
 * //License information must not be removed.
 * PHP version 5.2x
 *
 * @category	### Gripsell ###
 * @package		### Advanced ###
 * @arch		### Secured  ###
 * @author 		Development Team, Gripsell Technologies & Consultancy Services
 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @license		http://www.gripsell.com Clone Portal
 * @version		4.3.3
 * @since 		2011-11-16
 */
require_once(dirname(__FILE__) . '/app.php');
require_once(dirname(__FILE__) . '/facebook.php');
	

// Create our Application instance.
	$facebook = new FacebookB(array(
  	'appId' => $INI['system']['fbappid'],
  	'secret' => SECRET,
  	'cookie' => false,
	));
	
	

// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
	//$session = $facebook->getSession();
$uid = $facebook->getUser();
		$userinfo = null;
		// Session based API call.
		
		if ($uid) {
		  try {
			
			$userinfo = $facebook->api('/me');

		  } catch (FacebookApiException $e) {
			error_log($e);
		  }
		}
// login or logout url will be needed depending on current user state.
		if ($userinfo) {
		  $logoutUrl = $facebook->getLogoutUrl();
		  $_SESSION['FBCONNECT_LOGOUT_URL'] = $logoutUrl;
		} else {
		  $loginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
		}

	
		
		if($userinfo) {
			
			$api_client = new FacebookRestClient(APIKEY, SECRET, null);
			$user_details = $userinfo;
	
			$userExist = DB::GetTableRow('user', array(
						'facebook_uid' => $user_details['id'],
			));
		
			if($userExist) {
				$user_id = $userExist['id'];
				DB::Update('user',$user_id,array('avatar'=>$update_image),'id');
				
				DB::Update('user',$user_id,array('username'=>$user_details['first_name']),'id');
			} else {
				$user_row['password'] =  ZUser::GenPassword($user_row['password']);
				$user_row['create_time'] = $user_row['login_time'] = time();
				$user_row['ip'] = Utility::GetRemoteIp();
				$user_row['secret'] = md5(Utility::GenSecret(12));
				
				$user_row['gender'] = $user_details['gender']=='male' ? 'M' : 'F';
				$user_row['realname'] = $user_details['name'];
				
				$user_row['username'] = $user_details['first_name'];
				$user_row['facebook_uid'] = $user_details['id'];
				$user_row['facebook_url'] = $user_details['link'];
				$user_row['email'] 			= $user_details['email'];
				$user_id = ZUser::Create($user_row);
		}
	
		Session::Set('user_id', $user_id);
		ZLogin::Remember($login_user);	
	}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/helen');

$strSelectedProfiles	=	$_REQUEST["selected_profiles"];

?>

<script>
	<?php if($user_id || $strSelectedProfiles) { ?>
		closefunction();
	<?php } ?>
		
		function closefunction() {
			if (window.opener && !window.opener.closed) {
				window.opener.location.href = 'index.php';
				window.close();
			} 
		}
	
</script>

<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
	FB.init({
	appId : '<?php echo $facebook->getAppId(); ?>',
	session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
	status : true, // check login status
	cookie : true, // enable cookies to allow the server to access the session
	xfbml : true // parse XFBML
	});
	
	// whenever the user logs in, we refresh the page
	FB.Event.subscribe('auth.login', function() {
	window.location.reload();
});
};

(function() {
	var e = document.createElement('script');
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);
	}());
</script>
<script>

function facebookpopup(url){
  var url = url;
  window.open(url,'name','height=411,width=635,left=0,top=0,resizable=yes,scrollbars=yes,toolbar=no,status=yes')
}

</script>

<?php if($userinfo=='') { ?>
	<a style="cursor:pointer;" onClick="facebookpopup('<?php echo $loginUrl; ?>');">
		<img src="/themes/css/default/facebookconnect.gif">
	</a>
<?php } ?>