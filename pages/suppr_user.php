<?php 

session_start();

$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

if($curPageName == "index.php"){
    $lien = "./";
} else {
    $lien = "./../";
}

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

        $fichier = fopen('./../log/error_log_back_suppr_user.txt', 'c+b');
        fseek($fichier, filesize('./../log/error_log_back_suppr_user.txt'));
        fwrite($fichier, "\n\n Erreur suppression user. Erreur : " .$e);
        fclose($fichier);

        echo 'erreur suppression utilisateur';

        $sth = null;
        $conn = null;

    }

} 




?>