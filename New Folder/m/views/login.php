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

$error = '';

// if my account clicked
if ($_POST['myaccount'] && isset($_GET['act'])) {
    
    Utility::Redirect('index.php?view=myaccount');
    
    } 

// if user id session is set then redirect to my account
if (isset($_SESSION['usr_id']) && $_SESSION['usr_id']) {
    
    header('Location:index.php?view=myaccount');
    
    } 

// if logout is requested
if (isset($_GET['act']) && $_GET['act'] == 'logout') {
    
    if (isset($_POST['sign_out']) && isset($_SESSION['user_id_mobile'])) {
        
        unset($_SESSION['user_id_mobile']);
        
         unset($_SESSION['user_id']);
        
         ZLogin::NoRemember();
        
         // logout from facebook too
        require_once('../facebooklogout.php');
        
         } 
    
    header('location:index.php');
    
    } 

if (isset($_POST['username_or_email'])) {
    
    $login_user = ZUser::GetLogin($_POST['username_or_email'], $_POST['password']);
    
     if (!$login_user) {
        
        Session::Set('error', 'Failed in login');
        
         $error = 'Failed in login';
        
         // Utility::Redirect(WEB_ROOT . '/account/login.php');
        } 
    
/**
     * else if ($INI['system']['emailverify'] 
     * 
     * && $login_user['enable']=='N'
     * 
     * && $login_user['secret']
     * 
     * ) {
     * 
     * Session::Set('unemail', $_POST['email']);
     * 
     * Utility::Redirect(WEB_ROOT .'/account/verify.php');
     * 
     * }
     */else {
        
        Session::Set('user_id_mobile', $login_user['id']);
        
         ZLogin::Remember($login_user);
        
         Utility::Redirect(get_loginpage('index.php?view=home'));
        
         } 
    
    } 

$currefer = strval($_GET['r']);

if ($currefer) {
    Session::Set('loginpage', udecode($currefer));
} 

?>

<?php if (isset($error) && $error) {
    ?>

<div class="y"><?php echo $error;
    ?></div>

<?php } 
?>

<div id="content">

	<form action="index.php?view=login" method="post">

				<div class="inner">

					<p class="heading-1">Login</p>

					<form action="" method="get">

						<div class="login-left"><p>Email</p></div>

						<div class="login-right">

							<input class="i" id="session[username_or_email]" name="username_or_email" type="text" value="" />

						</div>

						<div class="clear"></div>

						

						<div class="login-left"><p>Password</p></div>

						<div class="login-right">

							<input class="i" id="session[password]" name="password" type="password" value="" />

						</div>

						<div class="clear"></div>

						

						<div class="login-btn">

							<input class="login" name="commit" type="submit" value="Submit" />

						</div>

					</form>

				</div>

	</form>			

</div>