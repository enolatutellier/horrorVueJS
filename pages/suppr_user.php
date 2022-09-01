<?php 

session_start();

$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

if($curPageName == "index.html"){
    $lien = "./";
} else {
    $lien = "./../";
}

require $lien.'pages/fonctions.php';
require $lien.'pages/conn_bdd.php';

if(!empty($_POST) && array_key_exists("id_user", $_POST)){

    $id_user = $_POST['id_user'];

    try{

        $sth = $conn->prepare("DELETE FROM user WHERE id_user = :id_user");
        $sth->bindParam(':id_user' , $id_user);
        $sth->execute();

        $sth = null;
        $conn = null;

        $_SESSION['suppr_user'] = true;

        echo 'suppression reussie';
    }

    catch(PDOException $e){

        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
        $format1 = '%A %d %B %Y %H:%M:%S';
        $date1 = strftime($format1);
        $fichier = fopen('./../log/error_log_back_suppr_user.txt', 'c+b');
        fseek($fichier, filesize('./../log/error_log_back_suppr_user.txt'));
        fwrite($fichier, "\n\n" .$date1. " - Erreur suppression user. Erreur : " .$e);
        fclose($fichier);

        echo 'erreur suppression utilisateur';

        $sth = null;
        $conn = null;

    }

} 




?>