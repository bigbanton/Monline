<?php

$to = $_GET['to'];

$from = $_GET['from'];

$url = $_GET['url'];

$title = $_GET['t'];

$subject = "Check out ".$title;

$msg = $_GET['msg'];

// Start email body

$message = $msg."

".$title." - ".$url."

-------------------------

This message was sent by ".$from." via ".$url.".";

// End email body

$dir = $_GET["dir"];

$headers = 'From: '. $from . "\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();

if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $from)) { ?>

<p style="color:red">Please enter a valid email address!</p>

<p style="float:right"><input name="back" type="button" value="Back" class="emailback" onclick="email_back();" /></p>

<?php } else { mail($to,$subject,$message,$headers); ?>

<p style="color:green">Your message was successfully shared!</p>

<p style="float:right"><input name="back" type="button" value="Share Again" onclick="email_back();" /></p>

<?php } ?>