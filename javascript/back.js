/* fichier javascript en mode strict */
"use strict"; 

/**
 * Pour retrouver le tr de la ligne du tableau (voir fonction ci-dessous).
 * @param {*} element 
 * @returns 
 */

// Fonction développée par Ludovic Naulot permettant de retrouver la ligne parent d'une table en fonction d'un élément de la ligne
function findElementTr(element) {
    if(element === undefined) {
        return undefined;
    }
    if(element.localName === "tr") {
        return element;
    }
    return findElementTr(element.parentNode);
}


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



/* Page back_tueurs */

function valider_tueur(){

    let nom_perso = document.getElementById('nom_perso').value;
    let date_apparition = document.getElementById('date_apparition').value;
    let type_perso = document.getElementById('type_perso').value;
    let bio_perso = document.getElementById('bio_perso').value;

    let masqueDate = /^(0?\d|[12]\d|3[01])-(0?\d|1[012])-((?:19|20)\d{2})$/;
    let date_valide = date_apparition.match(masqueDate);

    if (nom_perso==""){
        alert("Merci de saisir un nom de tueur");
        return false;
    } else if (date_apparition==""){
        alert("Merci de saisir la date d'apparition du tueur'");
        return false;
    } else if (bio_perso==""){
        alert("Merci de saisir la biographie du tueur");
        return false;
    } else if (type_perso=="Choix"){
        alert("Merci de sélectionner le type de tueur");
        return false;
    }else if (date_valide==null){
        alert("Merci de saisir une date au format indiqué");
        return false;
    } else {
        return true;
    }

}

function Suppr_tueur(event){

    let type_element= event.target.id;

    let id_bouton = "";

    if (type_element == ""){
        id_bouton = event.target.name;
    } else {
        id_bouton = event.target.id;
    }

    let tb_split_id = id_bouton.split("_");
    let id_tueur = tb_split_id[1];
    let donnees = {"id_tueur": id_tueur};

    fetch_post('./suppr_tueur.php', donnees).then(function(response) {

        if(response=='suppression reussie'){

            window.location.href = "back_tueurs.php";

        } else if (response=='erreur suppression tueur') {

            alert('Echec de la suppression du tueur - annulation');

        } else if (response=='echec connexion bdd') {

            alert('Echec de la connexion à la base de données - annulation');

        } else if (response=='test if echec') {

            alert('Echec identification du tueur - annulation');

        }

    });

}



/* Page back_categories */

function valider_categorie(){

    let nom_cat = document.getElementById('type_perso').value;

    if (nom_cat==""){
        alert("Merci de saisir un nom de catégorie");
        return false;
    } else {
        return true;
    }

}

function Suppr_categorie(event){

    let type_element= event.target.id;

    let id_bouton = "";

    if (type_element == ""){
        id_bouton = event.target.name;
    } else {
        id_bouton = event.target.id;
    }

    let tb_split_id = id_bouton.split("_");
    let id_cat = tb_split_id[1];
    let donnees = {"id_cat": id_cat};

    fetch_post('./suppr_categorie.php', donnees).then(function(response) {

        if(response=='suppression reussie'){

            window.location.href = "back_categories.php";

        } else if (response=='erreur suppression catégorie') {

            alert('Echec de la suppression de la catégorie - annulation');

        } else if (response=='echec connexion bdd') {

            alert('Echec de la connexion à la base de données - annulation');

        } else if (response=='test if echec') {

            alert('Echec identification de la catégorie - annulation');

        }

    });

}




/* Page back_medias */

//permet d'afficher ou non les champs sur le nombre de saison / le statut de la série en fonction du type de média
function toggleAffichage() {

    let divToggle = document.getElementById("toggleDiv");

    if (type_media.selectedIndex != 2) {
         divToggle.style.display = "none";
         document.getElementById("nb_saison").value = "";
         document.getElementById("statut_media").options.selectedIndex = 0;
    } else {
        divToggle.style.display = "flex";
    }

}

function valider_media(){

    let typeMedia = document.getElementById('type_media').value;
    let personnage = document.getElementById('perso').value;
    let titre = document.getElementById('nom_media').value;
    let dateSortie = document.getElementById('date_sortie').value;
    let nbSaison = document.getElementById('nb_saison').value;
    let statutMedia = document.getElementById('statut_media').value;

    if (typeMedia=="Choix"){
        alert("Merci de sélectionner le type de média");
        return false;
    } else if (personnage=="Choix"){
        alert("Merci de sélectionner le tueur concerné par le média");
        return false;
    } else if (titre==""){
        alert("Merci de saisir le titre du média");
        return false;
    } else if (dateSortie==""){
        alert("Merci de saisir la date de sortie / parution du média");
        return false;
    } else if (typeMedia=="série"){
        if (nbSaison==""){
            alert("Merci de saisir le nombre de saison");
            return false;
        } else if (statutMedia=="Choix"){
            alert("Merci de saisir de sélectionner le statut du média");
            return false;
        }
    } else {
        return true;
    }

}

function Suppr_media(event){

    let type_element= event.target.id;

    let id_bouton = "";

    if (type_element == ""){
        id_bouton = event.target.name;
    } else {
        id_bouton = event.target.id;
    }

    let tb_split_id = id_bouton.split("_");
    let id_media = tb_split_id[1];
    let donnees = {"id_media": id_media};

    fetch_post('./suppr_media.php', donnees).then(function(response) {

        if(response=='suppression reussie'){

            window.location.href = "back_medias.php";

        } else if (response=='erreur suppression catégorie') {

            alert('Echec de la suppression de la catégorie - annulation');

        } else if (response=='echec connexion bdd') {

            alert('Echec de la connexion à la base de données - annulation');

        } else if (response=='test if echec') {

            alert('Echec identification du média - annulation');

        }

    });

}






/* Valable pour toutes les pages du back office : */

// Fonction permettant le double click sur une cellule d'une table (exceptée la première pour ne pas permettre la modification de l'id)
$("tbody > tr > td:not(:first-child)").dblclick(function (e) {
    e.stopPropagation();      //<-------stop the bubbling of the event here
    var currentEle = $(this);
    var value = $(this).html();
    updateVal(currentEle, value);
});

// Fonction permettant la mise à jour de la valeur dans la cellule suite au double click)
function updateVal(currentEle, value) {
    $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
    var thVal = $(".thVal");
    thVal.focus();
    thVal.keyup(function (event) {
        if (event.keyCode == 13) {
            $(currentEle).html(thVal.val());
            save(thVal.val(), currentEle);
        }
    });

    thVal.focusout(function () {
        $(currentEle).html(thVal.val().trim());
        return save(thVal.val(), currentEle);
    });

}

// Fonction permettant la mise à jour de la valeur modifiée dans la base de données.
function save(value, currentEle) {

    let elementTr = findElementTr(currentEle[0]);

    let test_id_perso = elementTr.querySelector(".id-perso");
    let test_id_cat = elementTr.querySelector(".id-cat");

    if(test_id_perso!==null){

        let id_perso = elementTr.querySelector(".id-perso").innerHTML;
        let nom_perso = elementTr.querySelector(".nom-perso").innerHTML;
        let date_app_perso = elementTr.querySelector(".date-app").innerHTML;
        let nom_cat = elementTr.querySelector(".nom-cat").innerHTML;
        let bio_perso = elementTr.querySelector(".bio-perso").innerHTML;

        let donnees = {'id-perso': id_perso, 'nom-perso': nom_perso, 'date-app-perso': date_app_perso, 'nom-cat': nom_cat, 'bio-perso': bio_perso};

        fetch_post('./maj_tueur.php', donnees).then(function(response) {

            if(response=='modification reussie'){

                window.location.href = "back_tueurs.php";

            } else if (response=='erreur modification tueur') {

                alert('Echec de la suppression du tueur - annulation');

            } else if (response=='echec connexion bdd') {

                alert('Echec de la connexion à la base de données - annulation');

            } else if (response=='test if echec') {

                alert('Echec identification du tueur - annulation');

            }

        });

    } else if(test_id_cat!==null){

        let id_cat = elementTr.querySelector(".id-cat").innerHTML;
        let nom_cat = elementTr.querySelector(".nom-cat").innerHTML;

        let donnees = {'id-cat': id_cat, 'nom-cat': nom_cat};

        fetch_post('./maj_categorie.php', donnees).then(function(response) {

            if(response=='modification reussie'){

                window.location.href = "back_categories.php";

            } else if (response=='erreur modification categorie') {

                alert('Echec de la modification de la categorie - annulation');

            } else if (response=='echec connexion bdd') {

                alert('Echec de la connexion à la base de données - annulation');

            } else if (response=='test if echec') {

                alert('Echec identification de la catégorie - annulation');

            }

        });

    }

}
