<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    if (isset($_POST["page"])) {
        $page_no = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        if(!is_numeric($page_no))
            die("Error fetching data! Invalid page number!!!");
    } else {
        $page_no = 1;
    }

    require $lien.'pages/conn_bdd.php';
    
    $row_limit = 10;

    // get record starting position
    $start = (($page_no-1) * $row_limit);

    $sth = $conn->prepare("SELECT * FROM medias ORDER BY id_media LIMIT $start, $row_limit");
    $sth->execute();
    //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs

    while($media = $sth->fetch(PDO::FETCH_ASSOC)) {

        $timestamp = strtotime($media['date_media']); 
        $date_bon_format = date("d-m-Y", $timestamp );
        $id_tueur = $media['id_perso'];

        if ($media['fin_media']==2){
            $statut_media = "terminée";
        } else if ($media['fin_media']==1) {
            $statut_media = "en cours";
        } else {
            $statut_media = "";
        }

        try{

            $sth2 = $conn->prepare("SELECT nom_perso FROM personnage where id_perso = $id_tueur");
            $sth2->execute();
            $nom_tueur = $sth2->fetchColumn();

        }catch(PDOException $e){
                                
            $fichier = fopen('./../log/error_log_back_medias.txt', 'c+b');
            fseek($fichier, filesize('./../log/error_log_back_medias.txt'));
            fwrite($fichier, "\n\n Erreur import nom tueur. Erreur : " .$e);
            fclose($fichier);
        
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $sth2 = null;
            $conn = null;    
        }

        echo '<tr>
                <th scope="row" class="align-middle text-center id-media">'.$media['id_media'].'</th>
                <td class="align-middle text-center type-media">'.$media['categorie_media'].'</td>
                <td class="align-middle text-center nom-perso">'.$nom_tueur.'</td>
                <td class="align-middle text-center titre-media">'.$media['titre_media'].'</td>
                <td class="align-middle text-center date-sortie">'.$date_bon_format.'</td>
                <td class="align-middle text-center nb-saison">'.$media['nbr_saison_media'].'</td>
                <td class="align-middle text-center statut-serie">'.$statut_media.'</td>
                <td class="align-middle text-center">
                    <div class="d-flex flex-row centree">
                        <div >
                            <button type="button" class="btn" onclick="Suppr_media(event)" name="del_'.$media['id_media'].'">
                                <i name="del_'.$media['id_media'].'" class="fas fa-trash-can" id="del_'.$media['id_media'].'"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>';
    }

?>