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

// get the city to be changed
$ename = strval($_POST['cities']);

// process for changing the city
($currefer = strval($_GET['refer'])) || ($currefer = strval($_GET['r']));

if ($ename != 'none' && $ename != '') {
    
    // id instead of ename as id is passed through the select element
    $city = Table::Fetch('cities', $ename, 'id');
    
     if ($city) {
        
        cookie_city($city);
        
         $currefer = udecode($currefer);
        
         if ($currefer) {
            
            Utility::Redirect($currefer);
            
             } else if ($_SERVER['HTTP_REFERER']) {
            
            if (!preg_match('#' . $_SERVER['HTTP_HOST'] . '#', $_SERVER['HTTP_REFERER'])) {
                
                Utility::Redirect($INI['system']['mlocation'] . '/home.php');
                
                 } 
            
            if (preg_match('#/city#', $_SERVER['HTTP_REFERER'])) {
                
                Utility::Redirect($INI['system']['mlocation'] . '/home.php');
                
                 } 
            
            Utility::Redirect($_SERVER['HTTP_REFERER']);
            
             } 
        
        Utility::Redirect($INI['system']['mlocation'] . '/home.php');
        
         } 
    
    } 

$pageVars = 'view=home';

?>

<?php if (isset($error) && $error) {
    ?>

<div class="y"><?php echo $error;
    ?></div>

<?php } 
?>

<div class="heading-section">

	<form action="index.php?view=home" method="post">

		<div class="head-in">

		<p>Cities</p>

		<div class="country">	

			<select name="cities" class="country-drop">

				<?php echo Utility::Option(Utility::OptionArray($hotcities, 'id', 'name'), $city['id']);
?>

			</select>

		</div>

		<p>

			<input type="submit" name="update-submit" value="Change" class="buttons"/>

		</p>

	</div>

	</form>	

</div>