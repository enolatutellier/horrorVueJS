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

    if(!empty($_POST) && array_key_exists("id-media", $_POST)){

        try{

            $nomPerso = $_POST['nom-perso'];

            $sth = $conn->prepare("Select id_perso from personnage WHERE nom_perso = :nom_perso");
            $sth->bindParam(':nom_perso', $nomPerso);
            $sth->execute();
            $idPerso = $sth->fetchColumn();
            $sth = null;

            $idMedia = str_replace("'"," ",valid_donnees($_POST['id-media']));
            $dateSortie = str_replace("/","-",valid_donnees($_POST["date-sortie"]));
            $titreMedia = str_replace("'"," ",valid_donnees($_POST['titre-media']));
            $typeMedia = str_replace("'"," ",valid_donnees($_POST['type-media']));
            $nbSaison = str_replace("'"," ",valid_donnees($_POST['nb-saison']));
            $statutMedia = str_replace("'"," ",valid_donnees($_POST['statut-media']));

            // on remet la date dans l'autre sens au format aaaa-mm-jj
            $timestamp = strtotime($dateSortie); 
            $date_bon_format = date("Y-m-d", $timestamp);

            //On met à jour les données reçues dans la table medias
            $sth = $conn->prepare("UPDATE medias set id_perso=:id_perso, titre_media=:titre_media, date_media=:date_media, categorie_media=:type_media WHERE id_media=:id_media");
            $sth->bindParam(':id_perso', $idPerso);    
            $sth->bindParam(':titre_media', $titreMedia);
            $sth->bindParam(':date_media', $date_bon_format);
            $sth->bindParam(':type_media', $typeMedia);
            $sth->bindParam(':id_media', $idMedia);
            $sth->execute();
            $sth = null;

            //s'il s'agit d'une série et que l'on a donc des données concernant le nombre de saisons et le statut de la série, on met à jour ces deux champs dans la table
            if(is_int($nbSaison)==true && ($statutMedia=="en cours" | $statutMedia=="terminée")){

                //On met à jour les données reçues dans la table medias
                $sth = $conn->prepare("UPDATE medias set nbr_saison_media=:nb_saison, fin_media=:statut_media WHERE id_media=:id_media");
                $sth->bindParam(':nb_saison', $nbSaison);    
                $sth->bindParam(':statut_media', $statutMedia);
                $sth->bindParam(':id_media', $idMedia);
                $sth->execute();
                $sth = null;

            }

            //Fermeture de la connexion à la base de données
            $conn = null;

            $_SESSION['modif_media'] = true;

            echo 'modification reussie';

        }
        catch(PDOException $e){

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%A %d %B %Y %H:%M:%S';
            $date1 = strftime($format1);
            $fichier = fopen('./../log/error_log_back_maj_media.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_maj_media.txt'));
            fwrite($fichier, "\n\n" .$date1. " - Erreur mise à jour média. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur modification media';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>