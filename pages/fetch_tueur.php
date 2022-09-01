<?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/conn_bdd.php';

    if (isset($_GET['id_tueur'])){

        try{

            $idTueur = $_GET['id_tueur'];

            $sth = $conn->prepare("SELECT p.id_perso, p.nom_perso, p.date_creation_perso, c.nom_cat, p.bio_perso from personnage p INNER JOIN categorie c ON p.id_cat = c.id_cat where id_perso = $idTueur");
            $sth->execute();
            $data_tueur = $sth->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data_tueur);

        }
        catch(PDOException $e){

            $fichier = fopen('./../log/error_log_fetch_tueur.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_fetch_tueur.txt'));
            fwrite($fichier, "\n\n Erreur fetch tueur. Erreur : " .$e);
            fclose($fichier);

            echo 'echec';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'echec';

    }
?>