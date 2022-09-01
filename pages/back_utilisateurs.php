<!DOCTYPE html>

<?php

session_start();

if (!isset($_SESSION['login'])){
    $_SESSION['login'] = "non";
}

if (!isset($_SESSION['suppr_user'])){
    $_SESSION['suppr_user'] = false;
}

if ($_SESSION['suppr_user']== true){
    ?>
        <script type="text/javascript">
            alert ("Utilisateur supprimer !");
        </script>
    <?php
    $_SESSION['suppr_user']= false;
}

if (!isset($_SESSION['modif_user'])){
    $_SESSION['modif_user'] = false;
}

if ($_SESSION['modif_user']== true){
    ?>
        <script type="text/javascript">
            alert ("Utilisateur modifié avec succès !");
        </script>
    <?php
    $_SESSION['modif_user']= false;
}

if (!isset($_SESSION['ajout_user'])){
    $_SESSION['ajout_user'] = false;
}

if ($_SESSION['ajout_user']== true){
    ?>
        <script type="text/javascript">
            alert ("Utilisateur ajouté avec succès !");
        </script>
    <?php
    $_SESSION['ajout_user']= false;
}

$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

if ($curPageName == "index.php"){
    $lien = "./";
} else {
    $lien = "./../";
}

?>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Back Office Horror Killers</title>
    <link rel="shortcut icon" type="image/ico" href="./../media/icone.jpg">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="./../css/back.css"/>

</head>

<body>

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container">
                <a class="navbar-brand" href="./../index.php"> <img src="./../media/logo.jpg" width="35px"></a>
                <a class="navbar-brand" href="./../index.php">Horror Killers</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="back_office.php">Accueil Admin</a>
                        </li>
                        <?php
                                if ($_SESSION['login'] == 'oui') {
                                    echo '<li class="nav-item">
                                                <a class="nav-link active" href="back_tueurs.php">Tueurs</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="back_categories.php">Catégories</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="back_medias.php">Médias</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="back_images.php">Images</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="back_utilisateurs.php">Utilisateurs</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="deconnexion.php">Deconnexion</a>
                                            </li>';
                                }else{
                                    echo '<li><a class="nav-link active" aria-current="page" href= "connexion_admin.php">Connexion</a></li>';
                                }
                            ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>

        <?php

            if ($_SESSION['login'] == 'oui') {

                echo  '<div class="container pt-5">
                    <h3 class="mt-5">Ajouter un membres dans la base de donnée</h3>

                    <!-- Formulaire d ajout d utilisateurs dans la bdd-->
                    <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_user()" action="./../pages/ajout_user.php">
                        <div class="row mt-4 mb-3">
                            <div class="col">
                                <label for="nom_user" class="form-label">Nom user</label>
                                    <input type="text" class="form-control" id="nom_user" name="nom_user">
                            </div>

                            <div class="col">
                                <label for="mail_user" class="form-label">User Mail</label>
                                    <input type="text" class="form-control" id="mail_user" name="mail_user">
                            </div>

                            <div class="col">
                                <label for="mdp_user" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="mdp_user" name="mdp_user">';

                require $lien.'pages/conn_bdd.php';

                try {
                    //On insère une partie des données reçues dans la table
                    $sth = $conn->prepare("SELECT nom_user, mail_user, mdp_user FROM user ORDER BY id_user ASC");
                    $sth->execute();

                    $users = $sth->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    date_default_timezone_set('Europe/Paris');
                    setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                    $format1 = '%A %d %B %Y %H:%M:%S';
                    $date1 = strftime($format1);
                    $fichier = fopen('./../log/error_log_back_utilisateurs.txt', 'c+b');
                    fseek($fichier, filesize('./../log/error_log_back_utilisateurs.txt'));
                    fwrite($fichier, "\n\n" .$date1. " - Erreur import liste utilisateur. Erreur : " .$e);
                    fclose($fichier);

                    /*Fermeture de la connexion à la base de données*/
                    $sth = null;
                    $conn = null;
                };


                echo    '</div>
                                </div>
                        <!-- Bouton d\'ajout -->
                        <div class="row d-flex justify-content-center mt-5 mb-3">
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>


                    <!-- Trait de séparation -->
                    <div class="container">
                        <div class="divider py-1 bg-dark"></div>
                    </div>

                    <!-- liste des utilisateurs  -->
                    <div class="container mb-5 table-responsive">
                        <h3 class="mt-3 mb-4">Liste des utilisateurs</h3>
                    </div>';

                require $lien.'pages/conn_bdd.php';

                try{
                    $sth = $conn->prepare("SELECT * FROM user");
                    $sth->execute();

                    $users =
                    $sth->fetchAll(PDO::FETCH_ASSOC);

                    echo
                    '<table class="table table-striped" id="tableau_user">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-nowrap">N°Id Users <img class="fleches" src="' . $lien . 'media/up-and-down-arrows.png"></th>
                                <th scope="col" class="text-center text-nowrap">Nom <img class="fleches" src="' . $lien . 'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                <th scope="col" class="text-center text-nowrap"> Mail<img class="fleches" src="' . $lien . 'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                <th scope="col" class="text-center text-nowrap"> Mdp <img class="fleches" src="' . $lien . 'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                <th scope="col" class="text-center text-nowrap">Outils</th>
                            </tr>
                        </thead>
                        <tbody>';

                    foreach ($users as $user) {

                        $id_user = $user['id_user'];

                        echo '<tr>
                                <th scope="row" class="align-middle text-center id-user">' . $user['id_user'] . '</th>

                                <td class="align-middle text-center nom-user">' .$user['nom_user']. '</td>

                                <td class="align-middle text-center mail-user">' .$user['mail_user']. '</td>

                                <td class="align-middle text-center mdp_user">' .$user['mdp_user']. '</td>
                                
                                <td class="align-middle text-center">
                                    <div class="d-flex flex-row">
                                        <div>
                                            <button type="button" class="btn" onclick="Suppr_utilisateurs(event)" name="del_'.$user['id_user'].'">
                                                <i name="del_'.$user['id_user'].'" class="fas fa-trash-can" id="del_'.$user['id_user'].'"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>';
                        
                    };


                    echo    '</tbody>
                        </table>';

                    $sth = null;
                    $conn = null;
                } 
                catch(PDOException $e){

                    date_default_timezone_set('Europe/Paris');
                    setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                    $format1 = '%A %d %B %Y %H:%M:%S';
                    $date1 = strftime($format1);
                    $fichier = fopen('./../log/error_log_back_utilisateurs.txt', 'c+b');
                    fseek($fichier, filesize('./../log/error_log_back_utilisateurs.txt'));
                    fwrite($fichier, "\n\n" .$date1. " - Erreur import liste d'utilisateurs. Erreur : " .$e);
                    fclose($fichier);

                    $sth = null;
                    $conn = null;
                }

                echo '</div>';
            } else {
                echo '<div id="msg-non-log" class="col mt-4 mb-5">
                    Merci de vous connecter à votre compte pour accéder à l\'administration
                </div>';
            }
        ?>
        
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted d-flex justify-content-center">Tous droits réservés @Horror-Killers.com</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="./../javascript/tri_tableau.js"></script>
    <script src="./../javascript/back.js"></script>
</body>

</html>