<?php
	include("header.php");
?>

<!--Formulaire de connexion-->
<form action="index.php?action=signInVerif" method="post" class="signIn">
    <div class="form-group">
        <label for="pseudo">Pseudonyme</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo" aria-describedby="emailHelp" placeholder="Exemple: j.boneau">
    </div>
    <div class="form-group">
        <label for="pwd">Mot de Passe</label>
        <input type="password" class="form-control" name="pwd" class="pwd" placeholder="exemple: 1234">
        <small id="emailHelp" class="form-text text-muted">Nous ne donnerons jamais votre mot de passe à qui que ce soit.</small>
    </div>
    <button type="submit" class="btn btn-primary">Se Connecter</button>
    <a href="#">Pas encore de compte ?</a>
</form>

<!--Formulaire d'inscription-->
<form action="index.php?action=signUpVerif" method="post" class="signUp" style="display: none">
    <div class="form-group">
        <label for="fisrtName">Prénom</label>
        <input type="text" class="form-control fisrtName" aria-describedby="emailHelp" placeholder="Exemple: Jean">
    </div>
    <div class="form-group">
        <label for="lastName">Nom</label>
        <input type="text" class="form-control" id="lastName" aria-describedby="emailHelp" placeholder="Exemple: Bonneau">
    </div>
    <div class="form-group">
        <label for="email">Mail</label>
        <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="jean.bonneau@gmail.com">
    </div>
    <div class="form-group">
        <label for="phoneNumber">Numéro de téléphone</label>
        <input type="tel" class="form-control" id="phoneNumber" aria-describedby="emailHelp" placeholder="0633******">
    </div>
    <div class="form-group">
        <label for="pseudo">Pseudonyme</label>
        <input type="text" class="form-control" id="pseudo" aria-describedby="emailHelp" placeholder="Exemple: j.boneau">
    </div>
    <div class="form-group">
        <label for="pwd">Mot de Passe</label>
        <input type="text" class="form-control pwd" placeholder="exemple: 1234">
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>

<!--Script JQuery-->
<script type="text/javascript">
    $(document).ready(function() {
        $('a').click(function() {
            $('.signIn').hide();
            $('.signUp').show();
        });

        $('.signUp').submit(function(e) {
            var telRegex = /^(0[1-68])(?:[ _.-]?(\d{2})){4}$/
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/i;
            var pwdRegex = /^[a-z0-9_-]{6,18}$/;
            e.preventDefault();

            if (!emailRegex.test($('#email').val())) {
                $('#email').removeClass('form-control').addClass('error');
            } else {
                $('#email').removeClass('error').addClass("form-control");
            }
            if (!telRegex.test($('#phoneNumber').val())) {
                $('#phoneNumber').removeClass('form-control').addClass('error');
            } else {
                $('#phoneNumber').removeClass('error').addClass("form-control");
            }
            if (!pwdRegex.test($('.pwd').val())) {
                $('.pwd').removeClass('form-control').addClass('error');
            } else {
                $('.pwd').removeClass('error').addClass("form-control");
            }
        });
    });

</script>

<?php
	include("footer.php");
?>
