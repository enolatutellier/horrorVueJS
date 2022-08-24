<?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/conn_bdd.php';

    $sth = $conn->prepare("SELECT personnage.id_perso, personnage.nom_perso, images.lien_image FROM personnage join images ON personnage.id_perso = images.id_perso where images.categorie_image = 'portrait' ORDER BY id_perso");
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
?>