<?php 

    session_start();

    $curPageName = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);

    if($curPageName == "index.html") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    if(!empty($_POST) && array_key_exists("id-user", $_POST)){

        try{

            $nomUser = str_replace("'"," ",valid_donnees($_POST['nom_user']));
            $mailUser = str_replace("'"," ",valid_donnees($_POST['mail_user']));
            $mdpUser = str_replace("'"," ",valid_donnees($_POST['mdp_user']));

            $sth = $conn->prepare("UPDATE user set nom_user=:nom_user, mail_user=:mail_user, mdp_user=:mdp_user WHERE id_user=:id_user");

            $sth->bindParam(':nom_user', $nom_user);
            $sth->bindParam(':mail_user', $maillUser);
            $sth->bindParam(':mdp_user', $mdpUser);
            $sth->execute();

            //fermeture de la bdd

            $sth = null;
            $conn = null;

            $_SESSION['modif_user'] = true;

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

