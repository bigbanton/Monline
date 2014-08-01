<div id="mail_report"></div>

<form name="jshare_email_form" id="jshare_email_form">

  <div class="element">

    <label>To:</label>

    <textarea name="to" class="text" id="to" style="width:390px" onfocus="if (this.value == 'Enter your friends email address. Multiple emails? Use Commas...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your friends email address. Multiple emails? Use Commas...';}">Enter your friends email address. Multiple emails? Use Commas...</textarea>

  </div>

  <div class="element">

    <label>Your Email:</label>

    <input id="emailfrom" type="text" name="from" value="Your email address..." class="text" style="width:390px" onfocus="if (this.value == 'Your email address...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Your email address...';}" />

  </div>

  <div class="element">

    <label>Note:</label>

    <textarea name="msg" class="text" id="message" style="width:390px; height:74px;">Hi, Check out this cool deal.</textarea>

  </div>

  <div class="element">

    <input type="submit" id="submit" value="Send" class="text"/>

  </div>

</form>

<script type="text/javascript">

$(document).ready(function () {

    $('#jshare_email_form').submit(function () { // When form is submited, run function

        // Get the data from all the fields and php

        var to = $('#jshare_email #to');

        var from = $('#jshare_email input[name=from]');

        var message = $('#jshare_email #message');

        var url = '<?php echo $_GET["url"]; ?>';

        var title = '<?php echo $_GET["title"]; ?>'

        // Simple validation to make sure user entered something

        // If error found, add hightlight class to the text field

        if (to.val() == 'Enter your friends email address. Multiple emails? Use Commas...') {

            to.addClass('hightlight');

            return false;

        }

        else to.removeClass('hightlight');

        var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;

        var emailfrom = $("#emailfrom").val();

        if (from.val() == 'Your email address...' || !filter.test(emailfrom)) {

            from.addClass('hightlight');

            return false;

        }

        else from.removeClass('hightlight');

        if (message.val() == '') {

            message.addClass('hightlight');

            return false;

        }

        else message.removeClass('hightlight');

        // organize the data properly

        var data = 'to=' + to.val() + '&from=' + from.val() + '&url=' + encodeURIComponent(url) + '&msg=' + encodeURIComponent(message.val()) + '&dir=<?php echo $_GET["dir"]; ?>&t=' + encodeURIComponent(title);

        // disabled all the text fields

        $('#jshare_email .text').attr('disabled', 'true');

        // show the sending... text

        $('#jshare_email #submit').attr('value', 'Sending...');

        // Send email via ajax

        $('#jshare_email #mail_report').load('<?php echo $_GET["dir"]; ?>email/send_mail.php?' + data, function () {

            $('#jshare_email_form').fadeOut('slow', function () {

                $('#jshare_email #mail_report').fadeIn('slow');

                $('#jshare_email .text').removeAttr("disabled");

                $('#jshare_email #submit').attr('value', 'Send');

            });

        });

		

        //cancel the submit default behaviours

        return false;

    });

});

function email_back() {

    $('#jshare_email #mail_report').fadeOut('slow', function () {

        $('#jshare_email_form').fadeIn('slow');

        $('#mail_report').empty();

    });

}

</script>

