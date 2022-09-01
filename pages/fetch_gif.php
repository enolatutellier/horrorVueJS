<?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/conn_bdd.php';

    if(!empty($_POST) && array_key_exists("id-tueur", $_POST)){

        try{

            $idTueur = $_POST['id-tueur'];

            $sth = $conn->prepare("SELECT lien_image from images where (categorie_image = 'video-G' or categorie_image = 'video-D') and id_perso = $idTueur");
            $sth->execute();
            $data_gif = $sth->fetchAll(PDO::FETCH_ASSOC);

            $datas = [];

            foreach ($data_gif as $data) {
                array_push($datas, $data['lien_image']);
            }

            echo json_encode($datas);

        }
        catch(PDOException $e){

            $fichier = fopen('./../log/error_log_fetch_gifs.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_fetch_gifs.txt'));
            fwrite($fichier, "\n\n Erreur fetch gifs. Erreur : " .$e);
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