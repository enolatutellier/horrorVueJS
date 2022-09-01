<!DOCTYPE html>

<?php

    session_start();

    if (!isset($_SESSION['login'])){
        $_SESSION['login'] = "non";
    }

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/connexionAdmin.css">
    <title>Sign In Admin</title>
    <link rel="shortcut icon" type="image/ico" href="./../media/icone.jpg">
    <link rel="stylesheet" href="./../css/style.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="./../css/animations.css" type="text/css" charset="utf-8">
</head>

<body>

    <header>
        <div class="logo">
            <a href="../index.php"><img title="Horror-Killers" src="./../media/logo.jpg" alt="Logo site"></a>
            <a href="../index.php" class="nom-site blood">Horror-Killers</a>
        </div>
        <nav class="navbar">
            <div class="nav-links">
                <ul>
                    <?php
                        if ($_SESSION['login'] == 'oui') {
                            echo '<li><a href="./../pages/back_office.html">Back</a></li>
                                    <li><a href="./../pages/deconnexion.php">Deconnexion</a></li>';
                        }else{
                            echo '<li><a href="./../pages/connexion_admin.php">Connexion</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <!--<img src="./../media/menu.png" alt="logo burger" class="menu-hamburger">-->
        </nav>
    </header>

    <section>
        <div class="login">
            <h1 class="rouge">Log In</h1>
            <form method="post" action="./../pages/admin_conn.php" name="form-login">

                <label class="rouge">Pseudo</label>
                <input type="text" name="admin_name" autocomplete="off" />
                <label class="rouge">Mot de passe</label>
                <input type="password" name="mdp_user" />
                <input class="bouton-form" type="submit" name="valider" placeholder="Let me in"/>

            </form>
        </div>
    </section>

    <footer>
        <div class="pied"><p class="copyright"><span class="rouge">Horror-Killers © 2022</span></p></div>
    </footer>
</body>

</html>