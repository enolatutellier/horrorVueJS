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

    $typeMedia = str_replace("'"," ",valid_donnees($_POST["type_media"]));
    $personnage = str_replace("'"," ",valid_donnees($_POST["perso"]));
    $titre = str_replace("'"," ",valid_donnees($_POST["nom_media"]));
    $dateSortie = str_replace("'"," ",valid_donnees($_POST["date_sortie"]));
    $nbSaison = str_replace("'"," ",valid_donnees($_POST["nb_saison"]));
    $statutMedia = str_replace("'"," ",valid_donnees($_POST["statut_media"]));

    if (!empty($titre) && !empty($dateSortie) && ($personnage != "Choix") && ($typeMedia != "Choix")) {

        if (($typeMedia == "série") && (($nbSaison=="") | ($statutMedia == "Choix"))) {

            echo "Merci de vérifier les informations saisies";

        } else {
 
            // on remet la date dans l'autre sens au format aaaa-mm-jj
            $timestamp = strtotime($dateSortie); 
            $date_bon_format = date("Y-m-d", $timestamp );

            try{

                //On insère les données reçues dans la table medias
    
                // requête différente en fonction de si il s'agit d'une série car le nombre de champs à injecter diffère.
                if ($typeMedia == "série") {
    
                    $sth = $conn->prepare("INSERT INTO medias (id_perso, titre_media, date_media, categorie_media, nbr_saison_media, fin_media) VALUES
                            (:id_perso, :titre_media, :date_media, :categorie_media, :nbr_saison_media, :fin_media)");
                    $sth->bindParam(':id_perso', $personnage);    
                    $sth->bindParam(':titre_media', $titre);
                    $sth->bindParam(':date_media', $date_bon_format); 
                    $sth->bindParam(':categorie_media', $typeMedia); 
                    $sth->bindParam(':nbr_saison_media', $nbSaison); 
                    $sth->bindParam(':fin_media', $statutMedia); 
    
                } else {
                    
                    $sth = $conn->prepare("INSERT INTO medias (id_perso, titre_media, date_media, categorie_media) VALUES
                            (:id_perso, :titre_media, :date_media, :categorie_media)");
                    $sth->bindParam(':id_perso', $personnage);    
                    $sth->bindParam(':titre_media', $titre);
                    $sth->bindParam(':date_media', $date_bon_format); 
                    $sth->bindParam(':categorie_media', $typeMedia); 
    
                }
    
                $sth->execute();
    
                //Fermeture de la connexion à la base de données
                $sth = null;
                $conn = null;
    
                $_SESSION['ajout_media'] = true;
    
                //On renvoie l'utilisateur vers la page d'administration des tueurs
                header("Location:./../pages/back_medias.php");
    
            }
            catch(PDOException $e){
    
                //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                write_error_log("./../log/error_log_ajout_media.txt","Impossible d'injecter les données.", $e);
                echo 'Une erreur est survenue, injection des données annulée.';
    
                //Fermeture de la connexion à la base de données
                $sth = null;
                $conn = null;
            }

        }

    } else {
        echo "Merci de vérifier les informations saisies";
    }

?>

