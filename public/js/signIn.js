$(document).ready(function () {
    $('footer').hide();
    $('#aSignIn').click(function () {
        $('.signIn').hide();
        $('.signUp').show();
    });
    $('#aSignUp').click(function () {
        $('.signIn').show();
        $('.signUp').hide();
    });

    $('.signUp').submit(function (e) {
        //Regex
        var sTelRegex = /^(0[1-68])(?:[ _.-]?(\d{2})){4}$/
        var sEmailregex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/i;
        var sPwdRegex = /^[a-zA-Z0-9_-]{6,18}$/;
        var bltelRegex = false;
        var blEmailregex = false;
        var blPwdRegex = false;

        //Will block the submit
        e.preventDefault();

        //Test Regex Mail
        if (!sEmailregex.test($('#email').val())) {
            $('#email').removeClass('form-control').addClass('error');
            blEmailregex = false;
        } else {
            $('#email').removeClass('error').addClass("form-control");
            blEmailregex = true;
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
        if (!sPwdRegex.test($('#signUpPwd').val()) || $('#confpwd').val() != $('#signUpPwd').val()) {
            $('#signUpPwd').removeClass('form-control').addClass('error');
            blPwdRegex = false;
        } else {
            $('#signUpPwd').removeClass('error').addClass("form-control");
            blPwdRegex = true;
        }

        //Test Regex Conf Password
        if ($('#confpwd').val() != $('#signUpPwd').val()) {
            $('#confpwd').removeClass('form-control').addClass('error');
            blPwdRegex = false;
        } else {
            $('.confpwd').removeClass('error').addClass("form-control");
            blPwdRegex = true;
        }

        if (bltelRegex && blEmailregex && blPwdRegex) {
            $('.signUp').submit();
        }
    });
});
