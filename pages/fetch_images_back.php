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

    $sth = $conn->prepare("SELECT * FROM images ORDER BY id_image LIMIT $start, $row_limit");
    $sth->execute();
    //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs

    while($image = $sth->fetch(PDO::FETCH_ASSOC)) {

        $id_tueur = $image['id_perso'];

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
                <th scope="row" class="align-middle text-center id-img">'.$image['id_image'].'</th>
                <td class="align-middle text-center cat-img">'.$image['categorie_image'].'</td>
                <td class="align-middle text-center nom-perso">'.$nom_tueur.'</td>
                <td class="align-middle text-center lien-img">'.$image['lien_image'].'</td>
                <td class="align-middle text-center image"><img src="./../media/'.$image['lien_image'].'" width="35px"></td>
                <td class="align-middle text-center">
                    <div class="d-flex flex-row centree">
                        <div >
                            <button type="button" class="btn" onclick="Suppr_image(event)" name="del_'.$image['id_image'].'">
                                <i name="del_'.$image['id_image'].'" class="fas fa-trash-can" id="del_'.$image['id_image'].'"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>';
    }

?>