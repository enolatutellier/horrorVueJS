<!DOCTYPE html>

<?php

    session_start();

    if (!isset($_SESSION['login'])){
        $_SESSION['login'] = "non";
    }

    if (!isset($_SESSION['suppr_image'])){
        $_SESSION['suppr_image'] = false;
    }

    if ($_SESSION['suppr_image']== true){
        ?>
            <script type="text/javascript">
                alert ("Image supprimée avec succès !");
            </script>
        <?php
        $_SESSION['suppr_image']= false;
    }

    if (!isset($_SESSION['modif_image'])){
        $_SESSION['modif_image'] = false;
    }

    if ($_SESSION['modif_image']== true){
        ?>
            <script type="text/javascript">
                alert ("Image modifiée avec succès !");
            </script>
        <?php
        $_SESSION['modif_image']= false;
    }

    if (!isset($_SESSION['ajout_image'])){
        $_SESSION['ajout_image'] = false;
    }

    if ($_SESSION['ajout_image']== true){
        ?>
            <script type="text/javascript">
                alert ("Image ajoutée avec succès !");
            </script>
        <?php
        $_SESSION['ajout_image']= false;
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
                    <a class="navbar-brand" href="./../index.html"> <img src="./../media/logo.jpg" width="35px"></a>
                    <a class="navbar-brand" href="./../index.html">Horror-Killers</a>
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
                        <h3 class="mt-5">Ajout d\'une image dans la base de données</h3>
                        <!-- Formulaire d ajout d\'image dans la bdd -->
                        <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_image()" action="./../pages/ajout_image.php">
                            <div class="row mt-4 mb-3">
                                <div class="col">
                                    <label for="type_image" class="form-label">Catégorie Image</label>
                                    <select id="type_image" class="form-select" name="type_image" aria-label="Default select example">
                                        <option selected>Choix</option>
                                        <option value="portrait">portrait</option>
                                        <option value="carousel">carousel</option>
                                        <option value="background">background</option>
                                        <option value="video-G">video-G</option>
                                        <option value="video-D">video-D</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="perso" class="form-label">Personnage</label>
                                    <select id="perso" class="form-select" name="perso" aria-label="Default select example">
                                        <option selected>Choix</option>';
                                            
                                            require $lien.'pages/conn_bdd.php';

                                                try{

                                                    //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                                    $sth = $conn->prepare("SELECT id_perso, nom_perso FROM personnage ORDER BY id_cat ASC");
                                                    $sth->execute();
                                                    //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                                    $personnages = $sth->fetchAll(PDO::FETCH_ASSOC);

                                                    // on remplit la liste de sélection de console
                                                    foreach ($personnages as $personnage) {
                                                        echo '<option value="'.$personnage['id_perso'].'">'.$personnage['nom_perso'].'</option>';
                                                    };

                                                }
                                                catch(PDOException $e){

                                                    $fichier = fopen('./../log/error_log_back_media.txt', 'c+b');
                                                    fseek($fichier, filesize('./../log/error_log_back_media.txt'));
                                                    fwrite($fichier, "\n\n Erreur import liste tueurs. Erreur : " .$e);
                                                    fclose($fichier);
                            
                                                    /*Fermeture de la connexion à la base de données*/
                                                    $sth = null;  
                                                    $conn = null;  
                                                }
                                            
                        echo       '</select>
                                </div>
                            </div>
                            <div class="row mt-4 mb-3">
                                <div class="col-6">
                                    <label for="lien_img" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="lien_img" name="lien_img">
                                    <div id="emailHelp" class="form-text">Pas d\'apostrophe dans le nom - remplacer les espaces par des underscores - format jpg/jpeg/png/gif.</div>
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

                    <!-- liste des images  -->
                    <div class="container mb-5 table-responsive">
                        <h3 class="mt-3 mb-4">Liste des images</h3>';

                        try{

                            $sth = $conn->prepare("SELECT COUNT(id_image) FROM images");
                            $sth->execute();
                            //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                            $nb_images_tot = $sth->fetchColumn();

                            $sth = $conn->prepare("SELECT * FROM images LIMIT :limite OFFSET :debut");

                            $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
                            $limite = 12;
                            $debut = ($page - 1) * $limite;
                            $nombreDePages = ceil($nb_images_tot / $limite);

                            $sth->bindValue('limite', $limite, PDO::PARAM_INT);
                            $sth->bindValue('debut', $debut, PDO::PARAM_INT); 
                            $sth->execute();
                            //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                            $images = $sth->fetchAll(PDO::FETCH_ASSOC);

                            $total_pages = ceil($nb_images_tot/10);

                            echo   '<table class="table table-striped" id="tableau_images">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center text-nowrap">N° Id <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Catégorie <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Personnage <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Lien <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Image <img class="fleches" src="'.$lien.'media/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Outils</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pg-results">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="">
                                    <div class="pagination d-flex justify-content-center"></div>
                                </div>';

                            /*Fermeture de la connexion à la base de données*/
                            $sth = null;
                            $conn = null;
                        }
                        catch(PDOException $e){
                            
                            $fichier = fopen('./../log/error_log_back_images.txt', 'c+b');
                            fseek($fichier, filesize('./../log/error_log_back_images.txt'));
                            fwrite($fichier, "\n\n Erreur import liste images. Erreur : " .$e);
                            fclose($fichier);

                            /*Fermeture de la connexion à la base de données*/
                            $sth = null;
                            $conn = null;    
                        }          
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
        <script src="//rawgit.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#pg-results").load("fetch_images_back.php");
                $(".pagination").bootpag({
                    total: <?php echo $total_pages; ?>,
                    page: 1,
                    maxVisible: 15,
                    wrapClass: 'pagination',
                    activeClass: 'active',
                    disabledClass: 'disabled',
                }).on("page", function(e, page_num){
                    e.preventDefault();
                    $("#pg-results").load("fetch_images_back.php", {"page": page_num});
                });
            });
        </script>

        <script src="./../javascript/tri_tableau.js"></script> 
        <script src="./../javascript/back.js"></script> 
    </body>
    
</html>
