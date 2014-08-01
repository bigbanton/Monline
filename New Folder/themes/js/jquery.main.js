$(function(){
    //original field values
    var field_values = {
            //id        :  value
            'email'  : 'email address'
    };

    //inputfocus
   $('input#email').inputfocus({ value: field_values['email'] }); 

    //reset progress bar
    $('#progress').css('width','0%');
    $('#progress_text').html('0% Complete');

    //first_step
    $('form').submit(function(){ return false; });
    $('#submit_first').click(function(){
        //remove classes
        $('#first_step input').removeClass('error').removeClass('valid');     
  
                //update progress bar
                $('#progress_text').html('50% Complete');
                $('#progress').css('width','50%');
                
                //slide steps
                $('#skip').hide();   

                $('#first_step').slideUp();
                $('#second_step').slideDown();

    });

    $('#submit_second').click(function(){
        //remove classes
        $('#second_step input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = $('#second_step input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = $(this).val();
            if( value.length<1 || value==field_values[$(this).attr('id')] || ( $(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                $(this).addClass('error');
                $(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                //update progress bar

                $('#progress_text').html('100% Complete');

                $('#progress').css('width','100%');

				$(this).addClass('valid');
				$('#success').show();

            }
        });

        if(!error) {
        //send information to server

        var city    = $('#city').attr('value');  

		var email   = $('#email').attr('value');

		var ref 	= $.URLEncode('index.php')

		var urlref 	= $.base64.encode(ref);

			$.ajax({  

				type: "POST",  

				url: "subscribe.php",  

				data: "city_id="+ city +"& email="+ email,  

				success: function(){

					window.location="city.php?r="+urlref+"&ename="+city;    

				} 

			});  

        } else return false;

    });

});