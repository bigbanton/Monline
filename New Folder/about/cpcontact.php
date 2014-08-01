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

require_once(dirname(dirname(__FILE__)) . '/app.php');

$ob_content = ob_get_clean();

// error_reporting(E_ALL);

 if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

 $name = $_POST['name'];
 $email = $_POST['email'];
 $phone = $_POST['phone'];
 $subject = $_POST['subject'];
 $comments = $_POST['comments'];
 $verify = $_POST['verify'];

 if (trim($name) == '') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_YOU_MUST_ENTER_YOUR_NAME_EN);
    echo '</div>';
     exit();
     } else if (trim($email) == '') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_PLEASE_ENTER_A_VALID_EMAIL_ADDRESS_EN);
    echo '</div>';
     exit();
     } else if (trim($phone) == '') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_PLEASE_ENTER_A_VALID_PHONE_NUMBER_EN);
    echo '</div>';
     exit();
     } else if (!is_numeric($phone)) {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_PHONE_NUMBER_CAN_ONLY_CONTAIN_DIGITS_EN);
    echo '</div>';
     exit();
     } else if (!isEmail($email)) {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_YOU_HAVE_ENTER_AN_INVALID_E - MAIL_ADDRESS_EN);
    echo '</div>';
     exit();
     } 

if (trim($subject) == '') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_PLEASE_ENTER_A_SUBJECT_EN);
    echo '</div>';
     exit();
     } else if (trim($comments) == '') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_PLEASE_ENTER_YOUR_MESSAGE_EN);
    echo '</div>';
     exit();
     } else if (trim($verify) == '') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_PLEASE_ENTER_THE_VERIFICATION_NUMBER_EN);
    echo '</div>';
     exit();
     } else if (trim($verify) != '4') {
    echo '<div class="error_message">';
    echo __(TEXT_EN_ATTENTION_EN);
    echo '! ';
    echo __(TEXT_EN_THE_VERIFICATION_NUMBER_YOU_ENTERED_IS_INCORRECT_EN);
    echo '</div>';
     exit();
     } 

if (get_magic_quotes_gpc()) {
    $comments = stripslashes($comments);
     } 

// Configuration option.
// Enter the email address that you want to emails to be sent to.
// Example $address = "joe.doe@yourdomain.com";
// $address = "example@themeforest.net";
$address = $INI['system']['cpemail'];

 // Configuration option.
// i.e. The standard subject will appear as, "You've been contacted by John Doe."
// Example, $e_subject = '$name . ' has contacted you via Your Website.';
$e_subject = 'You\'ve been contacted by ' . $name . '.';

 // Configuration option.
// You can change this if you feel that you need to.
// Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.
$e_body = "You have been contacted by $name with regards to $subject. <br/><br/>The message is as follows.<br/>" . PHP_EOL . PHP_EOL;

 $e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;

 $e_reply = "<br/><br/>You can contact $name via email, $email or via phone $phone";

 $msg = wordwrap($e_body . $e_content . $e_reply, 70);

 $options = array(
    
    'contentType' => 'text/html',
    
     'encoding' => 'utf-8',
    
    );

 $headers = "From: $email" . PHP_EOL;

 $headers .= "Reply-To: $email" . PHP_EOL;

 $headers .= "MIME-Version: 1.0" . PHP_EOL;

 $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;

 $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

 if (Mailer::SendMail($email, $address, $e_subject, $msg, $options)) {
    
    
    
    // Email has sent successfully, echo a success page.
    
    
    echo "<fieldset>";
    
     echo "<div id='success_page'>";
    
     echo "<h1>";
    echo __(TEXT_EN_MESSAGE_SENT_SUCCESSFULLY_EN);
    echo "</h1>";
    
     echo "<p>";
    echo __(TEXT_EN_THANK_YOU_EN);
    echo " <strong>$name</strong>, ";
    echo __(TEXT_EN_YOUR_MESSAGE_HAS_BEEN_SUBMITTED_TO_US_EN);
    echo "</p>";
    
     echo "</div>";
    
     echo "</fieldset>";
    
     } 

function isEmail($email) // Email address verification, do not edit.
{
    
    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
    
    } 
?>