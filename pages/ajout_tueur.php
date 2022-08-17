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

    $nom_perso = str_replace("'"," ",valid_donnees($_POST["nom_perso"]));
    $date_apparition_perso = str_replace("/","-",valid_donnees($_POST["date_apparition"]));
    $type_perso = str_replace("'"," ",valid_donnees($_POST["type_perso"]));
    $bio_perso = str_replace("'"," ",valid_donnees($_POST["bio_perso"]));

    if (!empty($nom_perso) && !empty($date_apparition_perso) && !empty($type_perso) && !empty($bio_perso) && 
        strlen($nom_perso) <= 50 && strlen($type_perso) <= 50 && strlen($bio_perso) <= 3000) {

        // on remet la date dans l'autre sens au format aaaa-mm-jj
        $timestamp = strtotime($date_apparition_perso); 
        $date_bon_format = date("Y-m-d", $timestamp );

        try{
            //On insère une partie des données reçues dans la table jeux
            $sth = $conn->prepare("INSERT INTO personnage (nom_perso, date_creation_perso, id_cat, bio_perso) VALUES
                    (:nom_perso, :date_apparition_perso, :type_perso, :bio_perso)");
            $sth->bindParam(':nom_perso', $nom_perso);    
            $sth->bindParam(':date_apparition_perso', $date_bon_format);
            $sth->bindParam(':type_perso', $type_perso); 
            $sth->bindParam(':bio_perso', $bio_perso); 
            $sth->execute();

            //Fermeture de la connexion à la base de données
            $sth = null;
            $conn = null;

            $_SESSION['ajout_tueur'] = true;

                //On renvoie l'utilisateur vers la page d'administration des tueurs
                header("Location:./../pages/back_tueurs.php");

            }
            catch(PDOException $e){

                //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                write_error_log("./../log/error_log_ajout_tueur.txt","Impossible d'injecter les données.", $e);
                echo 'Une erreur est survenue, injection des données annulée.';

                //Fermeture de la connexion à la base de données
                $sth = null;
                $conn = null;
            }

    } else {
        echo "Merci de vérifier les informations saisies";
    }

?>

