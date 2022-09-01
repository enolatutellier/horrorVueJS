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
            $typeImg = $_GET['type_img'];

            $sth = $conn->prepare("SELECT lien_image from images where id_perso = $idTueur and categorie_image='$typeImg'");
            $sth->execute();
            $data_images = $sth->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data_images);

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