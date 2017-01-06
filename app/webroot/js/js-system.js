/**
  * var url
*/
const ADMIN = '/admin';

var domain = window.location.hostname;

$(document).ready(function() {
	$.validator.addMethod("PHONE", function(value, element) {
        return this.optional(element) || /^[0-9\s\+]{9,15}$/i.test(value);
    }, "Phone Number failse.");
	// validate and post ajax change password
	$('#change-password form').validate({
		rules: {
            password_update: {
                required: true,
                minlength : 6
            },
            re_password_update: {
                required: true,
                equalTo: "#password_update"
            }
       	},
	  	submitHandler: function(form) {
	    	var password_update = $('input[name="password_update"]').val();
	    	var re_password_update = $('input[name="re_password_update"]').val();
    		$.ajax({
				url: '/auth/changePassword',
				type: 'POST',
				data: {password_update: password_update, re_password_update: re_password_update},
			}).done(function(output) {
				if(output.status == 200) {
					alert(output.data.message);
					$('#change-password').modal('hide');
				}else{
					console.log(output);
				}
			});
	  	}
	});
});