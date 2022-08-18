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

    if(!empty($_POST) && array_key_exists("id_media", $_POST)){

        $id_media = $_POST['id_media'];

        try{

            $sth = $conn->prepare("DELETE FROM medias WHERE id_media = :id_media");
            $sth->bindParam(':id_media', $id_media);
            $sth->execute();
            
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            $_SESSION['suppr_media'] = true;

            echo 'suppression reussie';

        }
        catch(PDOException $e){

            $conn->rollBack();

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_back_suppr_media.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_suppr_media.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Erreur suppression média. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur suppression média';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>