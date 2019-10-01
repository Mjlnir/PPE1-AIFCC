$(document).ready(function () {
    var blPrenomNotNull = false;
    var blNomNotNull = false;
    var bltelRegex = false;
    var blEmailregex = false;
    var blPwdRegex = false;
    var blConfPwdEgal = false;

    $('footer').hide();
    $('#aSignIn').click(function () {
        $('.signIn').hide();
        $('.signUp').show();
    });
    $('#aSignUp').click(function () {
        $('.signIn').show();
        $('.signUp').hide();
    });

    $('#signUpError').hide();
    $('#signUpSuccess').hide();

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };
    
    var zaezae = getUrlParameter('success');
    alert(zaezae);


    $('.signUp').submit(function (e) {
        //Regex
        var sTelRegex = /^(0[1-68])(?:[ _.-]?(\d{2})){4}$/
        var sEmailregex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/i;
        var sPwdRegex = /^[a-zA-Z0-9_-]{6,18}$/;

        //Si l'un des booléens est faux, on stop le submit est on test les inputs
        if (!bltelRegex || !blEmailregex || !blPwdRegex ||
            !blPrenomNotNull || !blNomNotNull || !blConfPwdEgal) {


            //Will block the submit
            e.preventDefault();

            //Test First Name
            if ($('#firstName').val() == "") {
                $('#firstName').removeClass('form-control').addClass('error');
                blPrenomNotNull = false;
            } else {
                $('#firstName').removeClass('error').addClass("form-control");
                blPrenomNotNull = true;
            }

            //Test Last Name
            if ($('#lastName').val() == "") {
                $('#lastName').removeClass('form-control').addClass('error');
                blNomNotNull = false;
            } else {
                $('#lastName').removeClass('error').addClass("form-control");
                blNomNotNull = true;
            }

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
                blConfPwdEgal = false;
            } else {
                $('.confpwd').removeClass('error').addClass("form-control");
                blConfPwdEgal = true;
            }
        }

        /*if (bltelRegex && blEmailregex && blPwdRegex) {
            $('.signUp').submit();
            alert('OK');

        }*/
    });
});
