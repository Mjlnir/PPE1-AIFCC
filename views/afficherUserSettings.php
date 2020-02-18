<?php
    echo "<tr>";
    echo "<td scope=\"col\"><a href=\"#\" class=\"btnNomUtilisateur\" id=\"".$_SESSION['user']["idUtilisateur"]."\">".$_SESSION['user']["nomUtilisateur"]."</a></td>";
    echo "<td scope=\"col\"><a href=\"#\" class=\"btnPrenomUtilisateur\" id=\"".$_SESSION['user']["idUtilisateur"]."\">".$_SESSION['user']["prenomUtilisateur"]."</a></td>";
    echo "<td scope=\"col\"><a href=\"#\" class=\"btnMailUtilisateur\" id=\"".$_SESSION['user']["idUtilisateur"]."\">".$_SESSION['user']["mailUtilisateur"]."</a></td>";
    echo "<td scope=\"col\"><a href=\"#\" class=\"btnTelephoneUtilisateur\" id=\"".$_SESSION['user']["idUtilisateur"]."\">".$_SESSION['user']["telephoneUtilisateur"]."</a></td>";
    echo "<td scope=\"col\"><a href=\"#\" class=\"btnMdpUtilisateur\" id=\"".$_SESSION['user']["idUtilisateur"]."\">".$_SESSION['user']["passwordUtilisateur"]."</a></td>";
    echo "</tr>";
?>