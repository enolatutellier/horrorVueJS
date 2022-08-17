/* fichier javascript en mode strict */
"use strict"; 

/**
 * Pour retrouver le tr de la ligne du tableau.
 * @param {*} element 
 * @returns 
 */

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
        return save(thVal.val(), currentEle); // <---- Added missing semi-colon
    });

}

// Fonction permettant la mise à jour de la valeur modifiée dans la base de données.
function save(value, currentEle) {

    let elementTr = findElementTr(currentEle[0]);

    let id_perso = elementTr.querySelector(".id-perso").innerHTML;
    let id_cat = elementTr.querySelector(".id-cat").innerHTML;

    if(id_perso!=null){

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

    } else if(id_cat!=null){

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

function findElementTr(element) {
    if(element === undefined) {
        return undefined;
    }
    if(element.localName === "tr") {
        return element;
    }
    return findElementTr(element.parentNode);
}