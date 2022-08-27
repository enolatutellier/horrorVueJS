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

    if(!empty($_POST) && array_key_exists("id-image", $_POST)){

        try{

            $nomPerso = $_POST['nom-perso'];

            $sth = $conn->prepare("Select id_perso from personnage WHERE nom_perso = :nom_perso");
            $sth->bindParam(':nom_perso', $nomPerso);
            $sth->execute();
            $idPerso = $sth->fetchColumn();
            $sth = null;

            $idImage = str_replace("'"," ",valid_donnees($_POST['id-image']));
            $lienImage = str_replace("'"," ",valid_donnees($_POST['lien_img']));
            $typeImage = str_replace("'"," ",valid_donnees($_POST['type-image']));

            //On met à jour les données reçues dans la table medias
            $sth = $conn->prepare("UPDATE images set id_perso=:id_perso, categorie_image=:type_image, lien_image=:lien_image WHERE id_image=:id_image");
            $sth->bindParam(':id_perso', $idPerso);    
            $sth->bindParam(':type_image', $typeImage);
            $sth->bindParam(':lien_image', $lienImage);
            $sth->bindParam(':id_image', $idImage);
            $sth->execute();
            $sth = null;

            //Fermeture de la connexion à la base de données
            $conn = null;

            $_SESSION['modif_image'] = true;

            echo 'modification reussie';

        }
        catch(PDOException $e){

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_back_maj_image.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_maj_image.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Erreur mise à jour image. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur modification image';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>