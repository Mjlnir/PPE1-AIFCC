<?php
	include("header.php");
?>

<link rel="stylesheet" type="text/css" href="./public/css/signIn.css">
<script src="./public/js/signIn.js" type="text/javascript"></script>
</head>

<body>
    <!--Formulaire de connexion-->

    <form action="index.php?action=signInVerif" method="post" class="signIn">
        <?php
            if(isset($_SESSION['signUpSuccess'])){
                if($_SESSION['signUpSuccess'] == 1 && $_SESSION['signUpSuccess'] != ""){
                    echo "<div class=\"alert alert-success alert-dismissible fade show\" id=\"signUpSuccess\">
                            Le compte a bien été crée.
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                            </button>
                        </div>";
                }
                else
                {
                    echo "<div class=\"alert alert-danger alert-dismissible fade show\" id=\"signUpError\">
                            L'utilisateur existe déjà.
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                            </button>
                        </div>";
                }
                unset($_SESSION['signUpSuccess']);
            }
        ?>
        <h2>Connexion</h2>
        <div class="form-group row">
            <label for="pseudo" class="control-label col-sm-2 col-form-label">Pseudonyme:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="pseudo" id="pseudo" aria-describedby="emailHelp" placeholder="jbonneau">
                <small id="emailHelp" class="form-text text-muted">Première lettre du prénom suivit des sept premières lettres du nom.<br />Si cela ne marche pas, veuillez contacter un administrateur.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="pwd" class="control-label col-sm-2 col-form-label">Mot de Passe:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="signInPwd" name="pwd">
                <small id="emailHelp" class="form-text text-muted">Nous ne donnerons jamais votre mot de passe à qui que ce soit.</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <a href="#" id=aSignIn>Pas encore de compte ?</a>
            </div>
        </div>
    </form>

    <!--Formulaire d'inscription-->
    <form action="index.php?action=signUp" method="post" class="signUp" style="display: none">
        <small><a href="#" id="aSignUp"><span class="octicon octicon-chevron-left"></span> Connexion</a></small>
        <h2>Inscription</h2>
        <div class="form-group row">
            <label for="fisrtName" class="control-label col-sm-2 col-form-label">Prénom:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="firstName" aria-describedby="emailHelp" placeholder="Jean" name="prenom">
            </div>
        </div>
        <div class="form-group row">
            <label for="lastName" class="control-label col-sm-2 col-form-label">Nom:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="lastName" aria-describedby="emailHelp" placeholder="Bonneau" name="nom">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="control-label col-sm-2 col-form-label">Mail:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="jean.bonneau@gmail.com" name="mail">
            </div>
        </div>
        <div class="form-group row">
            <label for="phoneNumber" class="control-label col-sm-2 col-form-label">Téléphone:</label>
            <div class="col-sm-10">
                <input type="tel" class="form-control" id="phoneNumber" aria-describedby="emailHelp" placeholder="0633******" name="tel">
            </div>
        </div>
        <div class="form-group row">
            <label for="pwd" class="control-label col-sm-2 col-form-label">Mot de passe:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="signUpPwd" placeholder="1234" name="mdp">
            </div>
        </div>
        <div class="form-group row">
            <label for="pwd" class="control-label col-sm-2 col-form-label">Confirmation mot de passe:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="1234" id="confpwd">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
        </div>
    </form>

    <?php
	include("footer.php");
?>
