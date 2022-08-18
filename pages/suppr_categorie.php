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

    if(!empty($_POST) && array_key_exists("id_cat", $_POST)){

        $id_cat = $_POST['id_cat'];

        try{

            $sth = $conn->prepare("DELETE FROM categorie WHERE id_cat = :id_cat");
            $sth->bindParam(':id_cat', $id_cat);
            $sth->execute();
            
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            $_SESSION['suppr_categorie'] = true;

            echo 'suppression reussie';

        }
        catch(PDOException $e){

            $conn->rollBack();

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_back_suppr_categorie.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_suppr_categorie.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Erreur suppression catégorie. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur suppression catégorie';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>