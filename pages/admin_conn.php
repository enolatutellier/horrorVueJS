<?php
session_start();

require './../pages/conn_bdd.php';

if (isset($_POST['valider'])) {
    if (!empty($_POST['admin_name'] AND !empty($_POST['mdp_user']))) {
        //$pseudo_par_defaut = "admin";
        // $mdp_par_defaut = "$2y$10$Set2bz3/WSiO1CPV2r0gz.JbIfuCcO/yUgZ02P3KixRIuyj/FPC56"; 
        //root1234 ( je suis consciente qu'il ne doit pas être ici MERCI mais je vais PAS m'en souvenir)

        $pseudo_saisi = htmlspecialchars($_POST['admin_name']);
        $mdp_saisi = htmlspecialchars($_POST['mdp_user']);

        $sth = $conn->prepare("SELECT mdp_user FROM user WHERE nom_user='$pseudo_saisi'");
        $sth->execute();
        $mdp_bdd = $sth->fetchColumn();

        if (password_verify($mdp_saisi, $mdp_bdd)){
            $_SESSION['login'] = 'oui';

            header('Location:./../pages/back_office.html');

        } else {
            echo "Mot de passe ou pseudo incorrect";
        }

    } else {
        echo "Veuillez compléter tout les champs..";
    }
}
