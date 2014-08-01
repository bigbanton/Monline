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

 function isEmail($email)
{
    
     return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
    
     } 

$strName = $_GET['strName'];

 $strEmail = $_GET['strEmail'];

 $strCity = $_GET['strCity'];

 if (isEmail($strEmail)) {
    
    $address = $INI['system']['cpemail'];
    
     $e_subject = 'You\'ve been contacted by ' . $strName . '.';
    
     $e_body = "Hi Admin, <br><br>I have suggest you to add the city ($strCity) in your list. <br><br>" . PHP_EOL . PHP_EOL;
    
     $e_content = "Thanks $strName." . PHP_EOL . PHP_EOL;
    
     $e_reply = "";
    
    
    
     $msg = wordwrap($e_body . $e_content . $e_reply, 70);
    
    
    
     $options = array(
        
        'contentType' => 'text/html',
        
         'encoding' => 'utf-8',
        
        );
    
    
    
     $headers = "From: $strEmail" . PHP_EOL;
    
     $headers .= "Reply-To: $strEmail" . PHP_EOL;
    
     $headers .= "MIME-Version: 1.0" . PHP_EOL;
    
     $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    
     $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
    
    
    
    
    
     if (Mailer::SendMail($strEmail, $address, $e_subject, $msg, $options)) {
        
        print '<div id="citysuccesscontainer"><br>Your city suggestion has been received. Meanwhile, select a city near you to see the attractive deals</div>';
        
         } 
    
    } 

?>