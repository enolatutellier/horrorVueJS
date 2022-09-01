<?php
    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }
   
    require $lien.'pages/conn_bdd.php';

    if(!empty($_POST) && array_key_exists("id-cat", $_POST)){

        try{

            $idCat = str_replace("'"," ",valid_donnees($_POST['id-cat']));
            $nomCat = str_replace("'"," ",valid_donnees($_POST['nom-cat']));

            //On met à jour les données reçues dans la table personnage
            $sth = $conn->prepare("UPDATE categorie set nom_cat=:nom_cat WHERE id_cat=:id_cat");
            $sth->bindParam(':nom_cat', $nomCat);    
            $sth->bindParam(':id_cat', $idCat);
            $sth->execute();

            //Fermeture de la connexion à la base de données
            $sth = null;
            $conn = null;

            $_SESSION['modif_categorie'] = true;

            echo 'modification reussie';

        }
        catch(PDOException $e){

            $fichier = fopen('./../log/error_log_back_maj_categorie.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_maj_categorie.txt'));
            fwrite($fichier, "\n\n Erreur mise à jour catégorie. Erreur : " .$e);
            fclose($fichier);

            echo 'erreur modification categorie';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;    
        }

    } else {

        echo 'test if echec';

    }

?>