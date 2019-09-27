<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/user.css">
</head>

<body class="d-flex flex-column">
    <?php
        include("navbar.php");
    ?>
    <div id="page-content">
        <h2>Modifier ses informations</h2>
        <div>
            <table class="table">
                <tbody>
                    <?php
                        foreach($_SESSION['user'] as $key => $info)
                        {
                            echo "<tr><th>". $key ."</th><td scope=\"col\">". $info ."</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <label>Modifier les informations de la ligue</label>
        <div>

        </div>
    </div>
    <?php
	include("footer.php");
?>
