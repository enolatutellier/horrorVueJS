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

    if(!empty($_POST) && array_key_exists("id-perso", $_POST)){

        try{

            $nomCat = $_POST['nom-cat'];

            $sth = $conn->prepare("Select id_cat from categorie WHERE nom_cat = :nom_cat");
            $sth->bindParam(':nom_cat', $nomCat);
            $sth->execute();
            $idCat = $sth->fetchColumn();
            $sth = null;

            $idPerso = str_replace("'"," ",valid_donnees($_POST['id-perso']));
            $dateAppPerso = str_replace("/","-",valid_donnees($_POST["date-app-perso"]));
            $bioPerso = str_replace("'"," ",valid_donnees($_POST['bio-perso']));
            $nomPerso = str_replace("'"," ",valid_donnees($_POST['nom-perso']));

            // on remet la date dans l'autre sens au format aaaa-mm-jj
            $timestamp = strtotime($dateAppPerso); 
            $date_bon_format = date("Y-m-d", $timestamp );


            //On met à jour les données reçues dans la table personnage
            $sth = $conn->prepare("UPDATE personnage set nom_perso=:nom_perso, id_cat=:id_cat, bio_perso=:bio_perso, date_creation_perso=:date_app_perso WHERE id_perso=:id_perso");
            $sth->bindParam(':nom_perso', $nomPerso);    
            $sth->bindParam(':id_cat', $idCat);
            $sth->bindParam(':bio_perso', $bioPerso);
            $sth->bindParam(':date_app_perso', $date_bon_format);
            $sth->bindParam(':id_perso', $idPerso);
            $sth->execute();

            //Fermeture de la connexion à la base de données
            $sth = null;
            $conn = null;

            $_SESSION['suppr_tueur'] = true;

            echo 'modification reussie';

        }
        catch(PDOException $e){

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_back_maj_tueur.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_maj_tueur.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Erreur mise à jour tueur. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur modification tueur';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>