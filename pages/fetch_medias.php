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
            $typeMedia = $_GET['type_media'];

            if ($typeMedia=="série"){
                $sth = $conn->prepare("SELECT titre_media, date_media, nbr_saison_media, fin_media from medias where id_perso = $idTueur and categorie_media = '$typeMedia'");

            } else {
                $sth = $conn->prepare("SELECT titre_media, date_media from medias where id_perso = $idTueur and categorie_media = '$typeMedia'");
            }
            
            $sth->execute();
            $data_medias = $sth->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data_medias);

        }
        catch(PDOException $e){

            $fichier = fopen('./../log/error_log_fetch_medias.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_fetch_medias.txt'));
            fwrite($fichier, "\n\n Erreur fetch medias. Erreur : " .$e);
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