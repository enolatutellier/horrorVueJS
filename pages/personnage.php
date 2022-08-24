<?php

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    
    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    if (isset($_GET['id_tueur'])){
        $id_tueur = $_GET['id_tueur'];
    }

    require $lien.'pages/conn_bdd.php';
?>



<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/ico" href="./../media/icone.jpg">
        <title>Horror Killers</title>
    </head>

    <body>
        <?php
            echo ($id_tueur);

        ?>
    </body>
</html>