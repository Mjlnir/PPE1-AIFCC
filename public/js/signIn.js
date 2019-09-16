$(document).ready(function () {
    $('footer').hide();
    $('a').click(function () {
        $('.signIn').hide();
        $('.signUp').show();
    });

    $('.signUp').submit(function (e) {
        //Regex
        var sTelRegex = /^(0[1-68])(?:[ _.-]?(\d{2})){4}$/
        var sEmailregex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/i;
        var sPwdRegex = /^[a-z0-9_-]{6,18}$/;
        var bltelRegex = false;
        var blEmailregex = false;
        var blPwdRegex = false;

        //Will block the submit
        e.preventDefault();

        //Test Regex Mail
        if (!sEmailregex.test($('#email').val())) {
            $('#email').removeClass('form-control').addClass('error');
            blEmailregex = true;
        } else {
            $('#email').removeClass('error').addClass("form-control");
            blEmailregex = false;
        }
        //Test Regex PhoneNumber
        if (!sTelRegex.test($('#phoneNumber').val())) {
            $('#phoneNumber').removeClass('form-control').addClass('error');
            bltelRegex = false;
        } else {
            $('#phoneNumber').removeClass('error').addClass("form-control");
            bltelRegex = true;
        }
        //Test Regex Password
        if (!sPwdRegex.test($('.pwd').val())) {
            $('.pwd').removeClass('form-control').addClass('error');
            blPwdRegex = false;
        } else {
            $('.pwd').removeClass('error').addClass("form-control");
            blPwdRegex = true;
        }

        if (bltelRegex && blEmailregex && blPwdRegex) {
            $('.signUp').submit();
        }
    });
});
