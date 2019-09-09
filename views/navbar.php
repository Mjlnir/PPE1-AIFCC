<?php
    include("header.php");
?>

</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item active" id="home">
                <a class="nav-link" href="./views/home.php">Accueil</a>
            </li>
            <li class="nav-item" id="reservation">
                <a class="nav-link" href="./views/reservation.php">Réservation</a>
            </li>
            <li class="nav-item" id="calendrier">
                <a class="nav-link" href="./views/calendrier.php">Calendrier</a>
            </li>
            <li class="nav-item" id="user">
                <a class="nav-link" href="./views/user.php">Mon compte</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=logOut">Déconnexion</a>
            </li>
        </ul>
    </nav>
<script type="text/javascript">
    $(document).ready(function(){
        $('a').click(function(){
            
        });
    });
</script>
<?php
    include("footer.php");
?>