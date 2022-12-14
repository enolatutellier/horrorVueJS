<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    $catImage = str_replace("'"," ",valid_donnees($_POST["type_image"]));
    $nomPerso = str_replace("'"," ",valid_donnees($_POST["perso"]));
    $lienImage = valid_donnees($_FILES['lien_img']['name']);

    if (!empty($catImage) && !empty($nomPerso) && !empty($lienImage) &&  
        ($_FILES['lien_img']['type']=="image/png" || $_FILES['lien_img']['type']="image/jpg" || $_FILES['lien_img']['type']="image/jpeg" || $_FILES['lien_img']['type']="image/gif")) {

        // chemin complet de la jaquette choisie par l'utilisateur
        $file = $_FILES['lien_img']['tmp_name'];

        // dossier de sauvegarde de l'image après traitement
        $folder_save = $lien.'media/';

        try{

            //On insère une partie des données reçues dans la table jeux
            $sth = $conn->prepare("INSERT INTO images (id_perso, categorie_image, lien_image) VALUES
                    (:id_perso, :categorie_image, :lien_image)");
            $sth->bindParam(':id_perso', $nomPerso);    
            $sth->bindParam(':categorie_image', $catImage);
            $sth->bindParam(':lien_image', $lienImage); 
            $sth->execute();

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            switch ($catImage) {
                case "portrait": // portrait
                    modifier_image($file, $_FILES['lien_img']['name'], $folder_save, 625, 870);
                    break;
                case "carousel": // carousel
                    modifier_image($file, $_FILES['lien_img']['name'], $folder_save, 500, 375);
                    break;
                case "background": // background
                    modifier_image($file, $_FILES['lien_img']['name'], $folder_save, 266, 266);
                    break;
                case "video-G": // video-G
                    sauvegarder_image($file, $_FILES['lien_img']['name'], $folder_save);
                    break;
                case "video-D": // video-G
                    sauvegarder_image($file, $_FILES['lien_img']['name'], $folder_save);
                    break;
            }

            $_SESSION['ajout_image'] = true;

            //On renvoie l'utilisateur vers la page d'administration des jeux
            header("Location:./../pages/back_images.php");

        }
        catch(PDOException $e){

            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
            write_error_log("./../log/error_log_ajout_image.txt","Impossible d'injecter les données.", $e);
            echo 'Une erreur est survenue, injection des données annulée.';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }

    } else {

        echo "Merci de vérifier les informations saisies";

    }










?>

