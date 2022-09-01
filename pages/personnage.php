<!DOCTYPE html>

<?php

    session_start();

    if (!isset($_SESSION['login'])){
        $_SESSION['login'] = "non";
    }

?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/ico" href="./../media/icone.jpg">
        <title>Horror Killers</title>
    </head>

    <body>
        <div id="app">

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

                <div class="btn-audio">
                    <audio id="audio">
                        <source src="./../media/musique/Come-Play-with-Me.mp3" type="audio/mpeg">
                    </audio>
                    <button id="playPauseBTN" @click="playPause"><img src="./../media/soundOn.png"></button>
                    <button @click="stop"><img src="./../media/soundOff.png"></button>
                </div>  
            </header>

            <section class="wrapper">

                <div class="conteneur-section" v-for="(tueur) in tueur">
                    <h1 class="nom-tueur blood">{{ tueur.nom_perso }}</h1>
                    <div class="conteneur-entete">
                        <div class="conteneur-portrait">
                            <div class="conteneur-carte conteneur-carte-ligne">
                                <article class="carte" v-for="(imagePortrait) in imagesPortrait">
                                    <img class="image-tueur" v-bind:src="`./../media/${imagePortrait.lien_image}`" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                                </article>
                            </div>
                            
                        </div>
                        <div class="conteneur-infos">
                            <div class="details-infos">
                                <p class="rouge">Type : {{ tueur.nom_cat }}</p>
                                <p class="rouge">Date apparition : {{ tueur.date_creation_perso }}</p>
                            </div>
                            <p class="biographie rouge"> {{ tueur.bio_perso }} </p>
                        </div>
                    </div>
                    <div class="conteneur-medias">
                        <div class="conteneur-film">
                            <h5 class="rouge nom-section-media">Films</h5>
                            <ul>
                                <li v-for="(mediasFilm) in mediasFilm"><p class="rouge espaceLigne">{{ mediasFilm.titre_media }}</p></li>
                            </ul>
                        </div>
                        <div class="conteneur-serie">
                            <h5 class="rouge nom-section-media">Séries</h5>
                            <ul>
                                <li v-for="(mediasSerie) in mediasSerie"><p class="rouge espaceLigne">{{ mediasSerie.titre_media }}</p></li>
                            </ul>
                        </div>
                        <div class="conteneur-livre">
                            <h5 class="rouge nom-section-media">Livres / comics / bd</h5>
                            <ul>
                                <li v-for="(mediasLivre) in mediasLivre"><p class="rouge espaceLigne">{{ mediasLivre.titre_media }}</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="conteneur-images">
                        <div class="gallery">
                            <img v-for="(imageCarousel) in imagesCarousel" v-bind:src="`./../media/${imageCarousel.lien_image}`" role="img" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" focusable="false">
                        </div>
                    </div>
                </div>

            </section>

            <footer>
                <div class="pied"><p class="copyright"><span class="rouge">Horror-Killers © 2022</span></p></div>
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
                    tueur:[],
                    mediasFilm:[],
                    mediasSerie:[],
                    mediasLivre:[],
                    imagesPortrait:[],
                    imagesCarousel:[],
                }
            },
            mounted() {

                let urlParams = new URLSearchParams(window.location.search);
                let idTueur = urlParams.get('id_tueur');

                /* fetch infos tueur */
                let params = {
                    "id_tueur": idTueur
                };
                let query = Object.keys(params)
                            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
                            .join('&');

                let url_tueur = './../pages/fetch_tueur.php?' + query;

                fetch(url_tueur)
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    console.log(data);
                    this.tueur = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })


                /* fetch images */
                let paramsImg1 = {
                    "id_tueur": idTueur,
                    "type_img": "portrait"
                };
                let queryImg1 = Object.keys(paramsImg1)
                            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(paramsImg1[k]))
                            .join('&');

                let url_images1 = './../pages/fetch_images.php?' + queryImg1;

                fetch(url_images1)
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    console.log(data);
                    this.imagesPortrait = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })


                let paramsImg2 = {
                    "id_tueur": idTueur,
                    "type_img": "carousel"
                };
                let queryImg2 = Object.keys(paramsImg2)
                            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(paramsImg2[k]))
                            .join('&');

                let url_images2 = './../pages/fetch_images.php?' + queryImg2;

                fetch(url_images2)
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    console.log(data);
                    this.imagesCarousel = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })


                /* fetch filmographie */
                let paramsMedia1 = {
                    "id_tueur": idTueur,
                    "type_media": "film"
                };
                let queryMedia1 = Object.keys(paramsMedia1)
                            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(paramsMedia1[k]))
                            .join('&');

                let url_Media1 = './../pages/fetch_medias.php?' + queryMedia1;

                fetch(url_Media1)
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    console.log(data);
                    this.mediasFilm = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })

                /* fetch série */
                let paramsMedia2 = {
                    "id_tueur": idTueur,
                    "type_media": "série"
                };
                let queryMedia2 = Object.keys(paramsMedia2)
                            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(paramsMedia2[k]))
                            .join('&');

                let url_Media2 = './../pages/fetch_medias.php?' + queryMedia2;

                fetch(url_Media2)
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    console.log(data);
                    this.mediasSerie = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })

                /* fetch livre */
                let paramsMedia3 = {
                    "id_tueur": idTueur,
                    "type_media": "livre"
                };
                let queryMedia3 = Object.keys(paramsMedia3)
                            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(paramsMedia3[k]))
                            .join('&');

                let url_Media3 = './../pages/fetch_medias.php?' + queryMedia3;

                fetch(url_Media3)
                .then((response) => {
                    return response.json()
                })
                .then((data) => {
                    // Work with JSON data here
                    console.log(data);
                    this.mediasLivre = data;
                })
                .catch((err) => {
                    // Do something for an error here
                    console.log(err)
                })

                window.test=this;
                    
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
                }
            }
            }).mount('#app')


            /* Mise en place de l'ajout d'un écouteur d'évènement sur le déplacement de la souris, afin de lancer la musique lors de l'arrivée sur la page,
                puis on supprime l'écouteur d'évènement afin de ne pas relancer la musique lors de chaque déplacement de la souris. */
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
            };

            addListener(document, 'mousemove', myListener);
            // fin de la partie sur l'écouteur d'évènement du déplacement de la souris.

            // les deux fonctions ci-dessous permettent de transmettre des données à une page php depuis une fonction javascript 
            // et d'en récupérer le contenu / la réponse
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
                background-image: url("./../media/blood_bg.jpg");
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

            .nav-links ul{
                display: flex;
                flex-direction: row;
            }

            section{
                width: 100%;
                margin-left: auto;
                margin-right: auto;
                background: url("./../media/house_bg.jpg") no-repeat;
                background-size: cover;
            }

            .wrapper{
                flex:1;
            }

            .conteneur-section{
                display: flex;
                flex-direction: column;
                align-content: space-between;
                width: 50%;
                margin-left: auto;
                margin-right: auto;
                padding-top: 80px;
            }

            .nom-tueur{
                font-size: 50px;
                line-height: 60px;
                text-align: center;
                margin-left: auto;
                margin-right: auto;
            }

            .conteneur-entete{ 
                width: 100%;
                display: flex;
                flex-direction: row;
                align-content: space-between;
                padding-top: 80px;
                padding-bottom: 50px;
            }

            .conteneur-portrait{
                width: 50%;
            }

            .conteneur-infos{ 
                width: 50%;
                display: flex;
                flex-direction: column;
            }

            .details-infos{ 
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                text-align: center;
                font-size: 20px;
                margin-bottom: 35px;
            }

            .biographie{ 
                line-height:24px;
                font-size: 18px;
                max-height: 500px;
                overflow-y: auto;
                padding-right: 15px;
            }

            .carte {
                position: relative;
                vertical-align: top;
                width: 400px;
                border-radius: 24px;
                margin: auto;
                padding: 0 20px 0 20px;
            }

            .carte::after {
                content: "";
                position: absolute;
                width: calc(100% - 40px);
                height: 100%;
                top: 0;
                left: 20px;
                z-index: 1;
                border-radius: 24px;
                box-shadow: 0px 4px 32px 5px rgba(255, 0, 0, 0.75);
            }

            .carte img {
                max-width: 100%;
                border-radius: 24px;
            }

            .conteneur-medias{ 
                width: 100%;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                margin: 50px 0px;
                padding-left: 25px;
                padding-right: 25px;
            }

            .conteneur-film, .conteneur-serie, .conteneur-livre{ 
                width: 30%;
                display: flex;
                flex-direction: column;
                font-size: 20px;
            }

            .nom-section-media{ 
                font-size: 28px;
                margin-bottom: 25px;
                text-align: center;
            }

            .espaceLigne{ 
                margin-bottom: 10px;
            }

            .conteneur-images{
                width: 100%;
                margin-top: 50px;
                margin-bottom: 100px;
                padding-left: 25px;
                padding-right: 25px;
            }

            .gallery {
                --s: 30px; /* control the zig-zag size */
                
                display: grid;
                height: 500px;
                gap: 8px;
                grid-auto-flow: column;
                place-items: center;
                margin-left: auto;
                margin-right: auto;
                box-shadow: 0px 4px 32px 5px rgba(255, 0, 0, 0.75);
            }

            .gallery > img {
                width: 0;
                min-width: calc(100% + var(--s));
                height: 0;
                min-height: 100%;
                object-fit: cover;
                --mask: 
                    conic-gradient(from -135deg at right,#0000,#000 1deg 89deg,#0000 90deg) 
                    100% calc(50% + var(--_p,0%))/51% calc(2*var(--s)) repeat-y,
                    conic-gradient(from   45deg at left ,#0000,#000 1deg 89deg,#0000 90deg) 
                        0% calc(50% + var(--_p,0%))/51% calc(2*var(--s)) repeat-y;
                -webkit-mask: var(--mask);
                        mask: var(--mask);
                cursor: pointer;
                transition: .5s;
            }

            .gallery > img:nth-child(odd) {
                --_p: var(--s);
            }

            .gallery > img:hover {
                width: 20vw; 
            }

            .gallery > img:first-child {
                min-width: calc(100% + var(--s)/2);
                place-self: start;
                --mask: 
                    conic-gradient(from -135deg at right,#0000,#000 1deg 89deg,#0000 90deg) 
                    0 calc(50% + var(--_p,0%))/100% calc(2*var(--s));
            }

            .gallery > img:last-child {
                min-width: calc(100% + var(--s)/2);
                place-self: end;
                --mask: 
                    conic-gradient(from   45deg at left ,#0000,#000 1deg 89deg,#0000 90deg) 
                    0 calc(50% + var(--_p,0%)) /100% calc(2*var(--s));
            }

            .pied{
                z-index: 3;
                text-align: center;
                font-size: 20px;
                background-image: url("./../media/blood_bg.jpg");
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

        <link rel="stylesheet" href="./../css/style.css" type="text/css" charset="utf-8">
        <link rel="stylesheet" href="./../css/animations.css" type="text/css" charset="utf-8">

    </body>
</html>