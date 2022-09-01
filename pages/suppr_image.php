<?php
    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/conn_bdd.php';

    if(!empty($_POST) && array_key_exists("id_image", $_POST)){

        $id_image = $_POST['id_image'];

        try{

            $sth = $conn->prepare("DELETE FROM images WHERE id_image = :id_image");
            $sth->bindParam(':id_image', $id_image);
            $sth->execute();
            
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            $_SESSION['suppr_image'] = true;

            echo 'suppression reussie';

        }
        catch(PDOException $e){

            $fichier = fopen('./../log/error_log_back_suppr_image.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_suppr_image.txt'));
            fwrite($fichier, "\n\n Erreur suppression image. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur suppression image';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>