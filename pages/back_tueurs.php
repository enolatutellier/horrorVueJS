<!DOCTYPE html>

<?php

    session_start();

    if (!isset($_SESSION['login'])){
        $_SESSION['login'] = "non";
    }

    if (!isset($_SESSION['suppr_tueur'])){
        $_SESSION['suppr_tueur'] = false;
    }

    if ($_SESSION['suppr_tueur']== true){
        ?>
            <script type="text/javascript">
                alert ("Tueur supprimé avec succès !");
            </script>
        <?php
        $_SESSION['suppr_tueur']= false;
    }

    if (!isset($_SESSION['modif_tueur'])){
        $_SESSION['modif_tueur'] = false;
    }

    if ($_SESSION['modif_tueur']== true){
        ?>
            <script type="text/javascript">
                alert ("Tueur modifié avec succès !");
            </script>
        <?php
        $_SESSION['modif_tueur']= false;
    }

    if (!isset($_SESSION['ajout_tueur'])){
        $_SESSION['ajout_tueur'] = false;
    }

    if ($_SESSION['ajout_tueur']== true){
        ?>
            <script type="text/javascript">
                alert ("Tueur ajouté avec succès !");
            </script>
        <?php
        $_SESSION['ajout_tueur']= false;
    }

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
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
                    <a class="navbar-brand" href="./../index.php">Horror-Killers</a>
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
                    echo '<div class="container pt-5">
                        <h3 class="mt-5">Ajout d\'un personnage dans la base de données</h3>
                        <!-- Formulaire d ajout de personnage dans la bdd -->
                        <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_tueur()" action="./../pages/ajout_tueur.php">
                            <div class="row mt-4 mb-3">
                                <div class="col">
                                    <label for="nom_perso" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom_perso" name="nom_perso">
                                    <div id="emailHelp" class="form-text">50 caractères maximum.</div>
                                </div>
                                <div class="col">
                                    <label for="date_apparition" class="form-label">Date d\'apparition</label>
                                    <input type="text" class="form-control" id="date_apparition" name="date_apparition">
                                    <div id="emailHelp" class="form-text">Format jj-mm-aaaa</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                <label for="type_perso" class="form-label">Catégorie</label>
                                <select id="type_perso" class="form-select" name="type_perso" aria-label="Default select example">
                                    <option selected>Choix</option>';

                                        require $lien.'pages/conn_bdd.php';

                                            try{

                                                //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                                $sth = $conn->prepare("SELECT id_cat, nom_cat FROM categorie ORDER BY id_cat ASC");
                                                $sth->execute();
                                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                                $categories = $sth->fetchAll(PDO::FETCH_ASSOC);

                                                // on remplit la liste de sélection de console
                                                foreach ($categories as $categorie) {
                                                    echo '<option value="'.$categorie['id_cat'].'">'.$categorie['nom_cat'].'</option>';
                                                };

                                                /*Fermeture de la connexion à la base de données*/
                                                $sth = null;
                                            }
                                            catch(PDOException $e){

                                                $fichier = fopen('./../log/error_log_back_tueurs.txt', 'c+b');
                                                fseek($fichier, filesize('./../log/error_log_back_tueurs.txt'));
                                                fwrite($fichier, "\n\n Erreur import liste catégorie tueurs. Erreur : " .$e);
                                                fclose($fichier);
                        
                                                /*Fermeture de la connexion à la base de données*/
                                                $sth = null;
                                                $conn = null;    
                                            }
                                        
                    echo       '</select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="bio_perso" class="form-label">Biographie du personnage</label>
                                    <textarea type="text" class="form-control" id="bio_perso" name="bio_perso"></textarea>
                                    <div id="emailHelp" class="form-text">5000 caractères maximum.</div>
                                </div>
                            </div>

                            <!-- Bouton d\'ajout -->
                            <div class="row d-flex justify-content-center mt-5 mb-3">
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Trait de séparation -->
                    <div class="container">
                        <div class="divider py-1 bg-dark"></div>
                    </div>

                    <!-- liste des tueurs  -->
                    <div class="container mb-5 table-responsive">
                        <h3 class="mt-3 mb-4">Liste des tueurs</h3>';

                        require $lien.'pages/conn_bdd.php';

                        try{
                            $sth = $conn->prepare("SELECT * FROM personnage");
                            $sth->execute();
                            //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                            $tueurs = $sth->fetchAll(PDO::FETCH_ASSOC);

                        echo '<table class="table table-striped" id="tableau_personnage">
                                <thead>
                                    <tr>
                                    <th scope="col" class="text-center text-nowrap">N° Id <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                        <th scope="col" class="text-center text-nowrap">Nom <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                        <th scope="col" class="text-center text-nowrap">Date apparition <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                        <th scope="col" class="text-center text-nowrap">Catégorie <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                        <th scope="col" class="text-center text-nowrap">Biographie <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                        <th scope="col" class="text-center text-nowrap">Outils</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                foreach ($tueurs as $tueur) {

                                    $timestamp = strtotime($tueur['date_creation_perso']); 
                                    $date_bon_format = date("d-m-Y", $timestamp );
                                    $id_categorie = $tueur['id_cat'];

                                    try{

                                        $sth2 = $conn->prepare("SELECT nom_cat FROM categorie where id_cat = $id_categorie");
                                        $sth2->execute();
                                        $nom_cat = $sth2->fetchColumn();

                                    }catch(PDOException $e){
                                
                                        $fichier = fopen('./../log/error_log_back_tueurs.txt', 'c+b');
                                        fseek($fichier, filesize('./../log/error_log_back_tueurs.txt'));
                                        fwrite($fichier, "\n\n Erreur import nom catégorie tueur. Erreur : " .$e);
                                        fclose($fichier);
        
                                        /*Fermeture de la connexion à la base de données*/
                                        $sth = null;
                                        $sth2 = null;
                                        $conn = null;    
                                    }

                                    echo '<tr>
                                            <th scope="row" class="align-middle text-center id-perso">'.$tueur['id_perso'].'</th>
                                            <td class="align-middle text-center nom-perso">'.$tueur['nom_perso'].'</td>
                                            <td class="align-middle text-center date-app">'.$date_bon_format.'</td>
                                            <td class="align-middle text-center nom-cat">'.$nom_cat.'</td>
                                            <td class="align-middle text-center bio-perso elypse">'.$tueur['bio_perso'].'</td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex flex-row centree">
                                                    <div>
                                                        <button type="button" class="btn" onclick="Suppr_tueur(event)" name="del_'.$tueur['id_perso'].'">
                                                            <i name="del_'.$tueur['id_perso'].'" class="fas fa-trash-can" id="del_'.$tueur['id_perso'].'"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>';
                                };

                                echo    '</tbody>
                                    </table>';

                                /*Fermeture de la connexion à la base de données*/
                                $sth = null;
                                $conn = null;
                            }
                            catch(PDOException $e){
                                
                                $fichier = fopen('./../log/error_log_back_categories.txt', 'c+b');
                                fseek($fichier, filesize('./../log/error_log_back_categories.txt'));
                                fwrite($fichier, "\n\n Erreur import liste catégories. Erreur : " .$e);
                                fclose($fichier);

                                /*Fermeture de la connexion à la base de données*/
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




