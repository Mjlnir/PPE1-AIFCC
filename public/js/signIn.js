$(document).ready(function() {
        $('a').click(function() {
            $('.signIn').hide();
            $('.signUp').show();
        });

        $('.signUp').submit(function(e) {
            //Regex
            var telRegex = /^(0[1-68])(?:[ _.-]?(\d{2})){4}$/
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/i;
            var pwdRegex = /^[a-z0-9_-]{6,18}$/;
            
            //Will block the submit
            e.preventDefault();
            
            //Test Regex Mail
            if (!emailRegex.test($('#email').val())) {
                $('#email').removeClass('form-control').addClass('error');
            } else {
                $('#email').removeClass('error').addClass("form-control");
            }
            //Test Regex PhoneNumber
            if (!telRegex.test($('#phoneNumber').val())) {
                $('#phoneNumber').removeClass('form-control').addClass('error');
            } else {
                $('#phoneNumber').removeClass('error').addClass("form-control");
            }
            //Test Regex Password
            if (!pwdRegex.test($('.pwd').val())) {
                $('.pwd').removeClass('form-control').addClass('error');
            } else {
                $('.pwd').removeClass('error').addClass("form-control");
            }
        });
    });