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
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Horror Killers</title>
        <link rel="shortcut icon" type="image/ico" href="./media/icone.jpg">
    </head>

    <body>
        <div id="app">

            <header>
                <div class="logo">
                    <a href="#"><img title="Horror-Killers" src="./media/logo.jpg" alt="Logo site"></a>
                    <a href="#" class="nom-site blood">Horror-Killers</a>
                </div>
                <nav class="navbar">
                    <div class="nav-links">
                        <input class="search" type="text" v-model="search" placeholder="rechercher par nom..." />
                        <ul>
                            <?php
                                if ($_SESSION['login'] == 'oui') {
                                    echo '<li><a href="./pages/back_office.php">Back</a></li>
                                            <li><a href= "./pages/deconnexion.php">Deconnexion</a></li>';
                                }else{
                                    echo '<li><a href= "./pages/connexion_admin.php">Connexion</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                    <!--<img src="./media/menu.png" alt="logo burger" class="menu-hamburger">-->
                </nav>

                <div class="btn-audio">
                    <audio id="audio">
                        <source src="./media/musique/Come-Play-with-Me.mp3" type="audio/mpeg">
                    </audio>
                    <button id="playPauseBTN" @click="playPause"><img src="./media/soundOn.png"></button>
                    <button @click="stop"><img src="./media/soundOff.png"></button>
                </div>  
            </header>

            <section class="wrapper">
                <div class="intro">
                    <h1>Bienvenue !</h1>
                    <p>Venez d??couvrir ou red??couvrir les tueurs et les monstres les plus c??l??bres du monde de l'horreur.</p>
                </div>

                <div class="conteneur-section">
                    <div class="conteneur-elements">
                        <div class="conteneur-carte conteneur-carte-ligne">
                            <article class="carte" v-for="(result) in filteredResults" :key="result.nom_perso">
                                <figure class="figHover">
                                    <a @click="scream($event)">
                                        <img class="image-tueur" v-bind:src="`./media/${result.lien_image}`" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false" v-bind:id="`${result.id_perso}`"></img>
                                        <figcaption class="nom-tueur blood">{{ result.nom_perso }}</figcaption>
                                    </a>
                                </figure>
                            </article>
                            <div class="video-G">
                                <div style="width:100%;height:0;padding-bottom:56%;position:relative;">
                                    <iframe id="videoG" scrolling="no" width="100%" height="100%" style="position:absolute" frameBorder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                            <div class="video-D">
                                <div style="width:100%;height:0;padding-bottom:56%;position:relative;">
                                    <iframe id="videoD" scrolling="no" width="100%" height="100%" style="position:absolute" frameBorder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer>
                <div class="pied"><p class="copyright"><span class="rouge">Horror-Killers ?? 2022</span></p></div>
            </footer>

        </div>

        <script src="https://unpkg.com/vue@3"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            const { createApp } = Vue

            var audio = document.getElementById('audio');
            var playPauseBTN = document.getElementById('playPauseBTN');
            var count = 0;
            audio.loop = true;
            audio.volume = 0.75;
                        
            createApp({    
                data() {
                return {
                    results:[],
                    search: ""
                }
            },
            mounted() {

                fetch('./pages/fetch_data.php')
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    this.results = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })

                window.test=this;
                    
            },
            computed: {
                filteredResults() {
                    return this.results.filter(result => {
                        // return true if the product should be visible

                        // in this example we just check if the search string
                        // is a substring of the product name (case insensitive)
                        return result.nom_perso.toLowerCase().indexOf(this.search.toLowerCase()) != -1;
                    });
                }
            },
            methods: {
                playPause: function (event) {
                    if(count == 0){
                        count = 1;
                        audio.play();
                    }else{
                        count = 0;
                        audio.pause();
                    }
                },
                stop: function (event) {
                    this.playPause()
                    audio.pause();
                    audio.currentTime = 0;
                    
                },
                scream: function ($event) {

                    // tableau contenant les diff??rents effets sonores
                    let tableauEffetsSonores = ["screaming.mp3", "Stab.mp3", "creature_breath.mp3", "demonic_woman_scream.mp3", "wooden_door.mp3"]

                    // tirage d'un nombre al??atoire entre 1 et 5 pour choisir l'effet sonore ?? appliquer lors du click sur la fiche d'un tueur
                    const rndInt = Math.floor(Math.random() * 5)

                    // On r??cup??re l'effet sonore correspondant dans le tableau des effets
                    let effetSonore = tableauEffetsSonores[rndInt]

                    var screaming = new Audio('./media/musique/'+effetSonore)
                    screaming.volume = 1;
                    screaming.play();
                    let id_tueur = event.target.id;

                    setTimeout(() => {  window.location.href="./pages/personnage.php?id_tueur="+id_tueur;; }, 3000);
                }
            }
            }).mount('#app')


            /* Mise en place de l'ajout d'un ??couteur d'??v??nement sur le d??placement de la souris, afin de lancer la musique lors de l'arriv??e sur la page,
                puis on supprime l'??couteur d'??v??nement afin de ne pas relancer la musique lors de chaque d??placement de la souris. */
            var addListener, removeListener;

            if (document.addEventListener) {
                addListener = function (el, evt, f) { return el.addEventListener(evt, f, false); };
                removeListener = function (el, evt, f) { return el.removeEventListener(evt, f, false); };
            } else {
                addListener = function (el, evt, f) { return el.attachEvent('on' + evt, f); };
                removeListener = function (el, evt, f) { return el.detachEvent('on' + evt, f); };
            }

            var myListener = function () {
                removeListener(document, 'mousemove', myListener);
                window.test.playPause();

                // ajout d'un ??couteur d'??v??nement afin de d??tecter le survol des ??l??ments "figure" part la souris,
                // dans le but de pouvoir identifier l'id du tueur de la carte survol??e et mettre ?? jour 
                // les liens des gifs ?? la vol??e, pour afficher les 2 gifs du tueur survol??.
                const figures = document.querySelectorAll(".figHover");

                figures.forEach(figure => {

                    figure.addEventListener('mouseenter', function($event) {

                        let idTueur = event.target.querySelector('img').id;
                        let donnees = {'id-tueur': idTueur};

                        fetch_post('./pages/fetch_gif.php', donnees).then(function(response) {

                            if(response=='echec'){

                                alert('Echec fetch gifs');

                            } else {

                                let tabGif = JSON.parse(response);
                                let lien_1 = "./media/"+tabGif[0];
                                let lien_2 = "./media/"+tabGif[1];
                        
                                var gifG = document.getElementById('videoG');
                                gifG.setAttribute('src', lien_1);
                                var gifD = document.getElementById('videoD');
                                gifD.setAttribute('src', lien_2);

                            }

                        });

                    });

                });

            };

            addListener(document, 'mousemove', myListener);
            // fin de la partie sur l'??couteur d'??v??nement du d??placement de la souris.

            // les deux fonctions ci-dessous permettent de transmettre des donn??es ?? une page php depuis une fonction javascript 
            // et d'en r??cup??rer le contenu / la r??ponse
            function data(data) {

            let text = "";

            for (var key in data) {
            text += key + "=" + data[key] + "&";
            }

            return text.trim("&");
            }

            function fetch_post(url, dataArray) {

            let dataObject = data(dataArray);

            return fetch(url, {
                    method: "post",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: dataObject,
                })
                .then((response) => response.text())
                .catch((error) => console.error("Error:", error));

            }
        </script>

        <style>
            *{
                margin: 0;
                padding: 0;
                list-style: none;
                text-decoration: none;
            }

            body{
                min-height: 100vh;
                display:flex;
                flex-direction:column;
            }

            #app{
                height: 100vh;
            }

            header {
                display: flex;
                background-image: url("./media/blood_bg.jpg");
                background-size: cover;
                top: 0px;
                width: 100%;
                height: 6vh;
                position: sticky;
                z-index: 5;
                top: 0;
                padding: 20px 0;
                transition: all 0.2s ease-in-out;
            }

            header .logo {
                margin-left: 8%;
                margin-right: auto;
                transition: all 0.2s ease-in-out;
                display: flex;
                flex-direction: row;
                align-content: space-around;
            }

            header .logo img{
                width: 55px;
                margin-right: 35px;
            }

            header .logo .nom-site{
                font-size: 60px;
                -webkit-animation: flicker-5 8s linear infinite both;
	            animation: flicker-5 8s linear infinite both;
            }

            header .btn-audio{
                height: 100%;
                display: flex;
                flex-direction: column;
                margin-right: 10px;
            }

            header .navbar {
                height: 100%;
                margin-right: 5%;
                transition: all 0.2s ease-in-out;
                line-height: 50px;
            }

            .navbar a{
                color:rgb(255, 255, 255);
                letter-spacing: 1px; 
                font-size: 20px;
                margin-left: 30px;
            }

            .nav-links{ 
                display: flex;
                flex-direction: row;
                align-content: space-around;
            }

            ul{
                display: flex;
                flex-direction: row;
            }

            .search {
                display: block;
                width: 350px;
                margin: auto;
                padding: 10px 45px;
                background: white url("./media/search-icon.svg") no-repeat 15px center;
                background-size: 15px 15px;
                font-size: 16px;
                border: none;
                border-radius: 5px;
                box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
                    rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
            }

            section{
                width: 100%;
                margin-left: auto;
                margin-right: auto;
                background: url("./media/cimetiere.jpg") no-repeat;
                background-size: cover;
            }

            .wrapper{
                flex:1;
            }

            .intro{
                text-align: center;
            }

            .intro h1{
                font-size: 50px;
                color: rgb(255, 0, 0);
                background-color: rgba(31, 31, 31, 0.75);
            }

            .intro p{
                font-size: 30px;
                margin-bottom: 70px;
                color: rgb(255, 0, 0);
                background-color: rgba(31, 31, 31, 0.75);
            }

            section a:hover{
                cursor: url("./media/knife_curseur.png"),auto;
            }

            .conteneur-section{
                display: flex;
                flex-direction: row;
                align-content: space-between;
                width: 70%;
                margin-left: auto;
                margin-right: auto;
            }

            .conteneur-carte.conteneur-carte-ligne {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                flex-wrap: wrap;
                width: 75%;
                margin-left: auto;
                margin-right: auto;
                margin-top: 50px;
            }

            .carte {
                position: relative;
                vertical-align: top;
                width: 175px;
                border-radius: 24px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 50px;
                padding: 0 20px 0 20px;
            }

            .carte:hover {
                transform: scale(1.05);
                -webkit-animation: flicker-5 8s linear infinite both;
	            animation: flicker-5 8s linear infinite both;
            }

            .carte:hover ~ .video-D, .carte:hover ~ .video-G{
                visibility: visible;
            }

            .carte::after {
                content: "";
                position: absolute;
                width: calc(100% - 40px);
                height: 100%;
                top: 0;
                left: 20px;
                z-index: 1;
                background-color: rgb(0, 0, 0);
                border-radius: 24px;
                box-shadow: 0px 4px 32px 5px rgba(255, 0, 0, 0.75);
            }

            .carte img {
                max-width: 100%;
                border-top-left-radius: 24px;
                border-top-right-radius: 24px;
            }

            .carte figure {
                position: relative;
                z-index: 2;
                margin: 0;
                border-radius: 24px;
            }

            .carte figcaption {
                text-align: center;
                line-height: 28px;
                font-size: 18px;
                padding: 20px;
            }

            .video-D, .video-G{
                visibility: hidden;
                z-index: 1001;
                position: fixed;
                top: calc(55% - (250px / 2));
                width: 300px;
                height: 250px;
            }
            .video-D{
                right: 0;
            }
            .video-G{
                left: 0;
            }

            .pied{
                z-index: 3;
                text-align: center;
                font-size: 20px;
                background-image: url("./media/blood_bg.jpg");
                background-size: cover;
                height: 5vh;
                width: 100%;
                transform:scaleX(-1);
                box-sizing:border-box;
                padding: 0;
            }

            .copyright{
                margin: 0;
                line-height: 40px;
                transform:scaleX(-1);
            }

        </style>

        <link rel="stylesheet" href="./css/style.css" type="text/css" charset="utf-8">
        <link rel="stylesheet" href="./css/animations.css" type="text/css" charset="utf-8">
    </body>

</html>