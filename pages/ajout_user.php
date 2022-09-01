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

$nom_user = str_replace("'", " ", valid_donnees($_POST["nom_user"]));
$mail_user = str_replace("/", "-", valid_donnees($_POST["mail_user"]));
$password =  str_replace("/", "-", valid_donnees($_POST["mdp_user"]));
$pwd_hashed = password_hash($password, PASSWORD_ARGON2ID);

if (!empty($nom_user) <= 20 && strlen($mail_user) <= 20 && strlen($pwd_hashed) <= 100){

try{
    $sth = $conn->prepare("INSERT INTO user (nom_user, mail_user, mdp_user) VALUES 
            (:nom_user, :mail_user, :mdp_user)");
    // $sth->bindParam(':id_user', $id_user);
    $sth->bindParam(':nom_user', $nom_user);
    $sth->bindParam(':mail_user', $mail_user);
    $sth->bindParam(':mdp_user', $pwd_hashed);
    $sth->execute();


    $sth = null;
    $conn = null;

    $_SESSION['ajout_user'] = true;

        header("Location:./../pages/back_utilisateurs.php");
}

catch(PDOException $e){

        // echo 'Impossible de traiter les données, erreur : .$e->getMessage:();
    write_error_log("./../log/error_log_ajout_utilisateurs.txt", "Impossible d'injecter les données.", $e);
    echo 'Une erreur est survenue, injection des données annulée.';

    //fermeture de la bdd
    $sth = null;
    $conn = null;
}

} else {
    echo "Merci de verifier les informations saisies";
}

?>