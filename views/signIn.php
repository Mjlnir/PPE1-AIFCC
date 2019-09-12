<?php
	include("header.php");
?>

<link rel="stylesheet" type="text/css" href="./public/css/signIn.css">
<script src="./public/js/signIn.js" type="text/javascript"></script>
</head>

<body>
    <!--Formulaire de connexion-->
    <form action="index.php?action=signInVerif" method="post" class="signIn">
        <div class="inline">
            <img src="./public/image/Triathlon_all_3_stages_pictogram.svg">
        </div>
        <div class="inline">
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
            </div>
    </form>

    <!--Formulaire d'inscription-->
    <form action="index.php?action=signUpVerif" method="post" class="signUp" style="display: none">
        <div class="inline">
            <img src="./public/image/Triathlon_all_3_stages_pictogram.svg">
        </div>
        <div class="inline">
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
            </div>
    </form>

    <?php
	include("footer.php");
?>
