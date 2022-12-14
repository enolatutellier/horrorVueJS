<!DOCTYPE html>

<?php

    session_start();

    if (!isset($_SESSION['login'])){
        $_SESSION['login'] = "non";
    }

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

?>

<html lang="fr">
    <head>
        <title>Back Office Horror Killers</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/ico" href="./../media/icone.jpg">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Custom styles for this template -->
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
        <link rel="stylesheet" href="./../css/back.css">
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
                                                <a class="nav-link active" href="back_categories.php">Cat??gories</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="back_medias.php">M??dias</a>
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

        <main class="flex-shrink-0">
            <div class="container pt-5">
            <?php
            if ($_SESSION['login'] == 'oui') {

                echo '<div class="col mt-5 mx-auto">
                        <a class="text-decoration-none text-dark" href="back_tueurs.php">
                            <div class="card shadow p-3 mb-5 bg-white rounded w-75 mx-auto">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                    <img class="bd-placeholder-img img-fluid" src="./../media/tueurs.png" width="100%" height="250" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Tueurs</h5>
                                            <p class="card-text">Ici vous pouvez ajouter ou supprimer des personnages du site.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col mt-5 mx-auto">
                        <a class="text-decoration-none text-dark" href="back_categories.php">
                            <div class="card shadow p-3 mb-5 bg-white rounded w-75 mx-auto">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                    <img class="bd-placeholder-img img-fluid" src="./../media/categorie.jpg" width="100%" height="250" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Cat??gories</h5>
                                            <p class="card-text">Ici vous pouvez ajouter ou supprimer des cat??gories de personnage du site.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col mt-4 mb-4 mx-auto">
                        <a class="text-decoration-none text-dark" href="back_medias.php">
                            <div class="card shadow p-3 mb-5 bg-white rounded w-75 mx-auto">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img class="bd-placeholder-img img-fluid" src="./../media/filmo.jpg" width="100%" height="50" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">M??dias</h5>
                                            <p class="card-text">Ici vous pouvez ajouter ou supprimer des m??dias du site, concernant les personnages (films, s??ries, etc.).</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col mt-4 mb-5">
                        <a class="text-decoration-none text-dark" href="back_images.php">
                            <div class="card shadow p-3 mb-5 bg-white rounded w-75 mx-auto">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img class="bd-placeholder-img img-fluid" src="./../media/images.jpg" width="100%" height="250" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Images</h5>
                                            <p class="card-text">Ici vous pouvez ajouter ou supprimer des images li??es aux personnages du site.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col mt-4 mb-5">
                        <a class="text-decoration-none text-dark" href="./../pages/back_users.php">
                            <div class="card shadow p-3 mb-5 bg-white rounded w-75 mx-auto">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img class="bd-placeholder-img img-fluid" src="./../media/silhouette.png" width="100%" height="250" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Utilisateurs</h5>
                                            <p class="card-text">Ici vous pouvez ajouter ou supprimer des utilisateurs du site.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>';
            } else {
                echo '<div id="msg-non-log" class="col mt-4 mb-5">
                        Merci de vous connecter ?? votre compte pour acc??der ?? l\'administration
                    </div>';
            }
            ?>
            </div>
        </main>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <span class="text-muted d-flex justify-content-center">Tous droits r??serv??s @Horror-Killers.com</span>
            </div>
        </footer>

        <script src="./../javascript/back.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    </body>

</html>