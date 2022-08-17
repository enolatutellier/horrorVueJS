<?php
    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.html") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    if(!empty($_POST) && array_key_exists("id-cat", $_POST)){

        try{

            $idCat = $_POST['id-cat'];
            $nomCat = $_POST['nom-cat'];

            //On met à jour les données reçues dans la table personnage
            $sth = $conn->prepare("UPDATE categorie set nom_cat=:nom_cat WHERE id_cat=:id_cat");
            $sth->bindParam(':nom_cat', $nomCat);    
            $sth->bindParam(':id_cat', $idCat);
            $sth->execute();

            //Fermeture de la connexion à la base de données
            $sth = null;
            $conn = null;

            echo 'modification reussie';

        }
        catch(PDOException $e){

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_back_maj_categorie.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_maj_categorie.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Erreur mise à jour catégorie. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur modification categorie';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>