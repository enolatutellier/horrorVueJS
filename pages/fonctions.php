<?php

    function write_error_log ($nom_fichier, $message, $e){

        $fichier = fopen($nom_fichier, 'c+b');
        fseek($fichier, filesize($nom_fichier));
        fwrite($fichier, "\n\n" .$message. " - Erreur : " .$e);
        fclose($fichier);

    }

    function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

    function type_valide($type) {
        return ($type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG || $type == IMAGETYPE_JPG || $type == IMAGETYPE_GIF);
    }
    
    function save_image($filename, $new_name, $type) {
        if ($filename !== FALSE) {
            if( $type == IMAGETYPE_JPEG ) {
                imagejpeg($filename, $new_name);
            }
            elseif( $type == IMAGETYPE_PNG ) {
                imagepng($filename,$new_name);
            }
            elseif( $type == IMAGETYPE_JPG ) {
                imagejpeg($filename, $new_name);
            }
            elseif( $type == IMAGETYPE_GIF ) {
                imagegif($filename, $new_name);
            }
            imagedestroy($filename);
        }
    }
    
    function type_image_create($filename, $type) {
        if ($filename !== FALSE) {
            if( $type == IMAGETYPE_JPEG ) {
                return imagecreatefromjpeg($filename);
            }
            elseif( $type == IMAGETYPE_PNG ) {
                return imagecreatefrompng($filename);
            }
            elseif( $type == IMAGETYPE_JPG ) {
                return imagecreatefromjpeg($filename);
            }
            elseif( $type == IMAGETYPE_GIF ) {
                return imagecreatefromgif($filename);
            }
            return null;
        }
    }

    function image_resize($filename, $width_max, $height_max) {
        list($width, $height, $type) = getimagesize($filename);
        $newwidth = $width;
        $newheight = $height;
        $divWidth = $width / $width_max;
        $divHeight = $height / $height_max;
    
        if($divWidth > $divHeight) {
            $newwidth = $width / $divHeight;
            $newheight = $height / $divHeight;
        } else {
            $newwidth = $width / $divWidth;
            $newheight = $height / $divWidth;
        }
    
        $position_x = ($newwidth-$width_max)/2;
        if($position_x < 0) {
            $position_x = 0;
        }
    
        $position_y = ($newheight-$height_max)/2;
        if($position_y < 0) {
            $position_y = 0;
        }
        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = type_image_create($filename, $type);
    
        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $thumb_final = imagecrop($thumb, ['x' => $position_x, 'y' => $position_y, 'width' => $width_max, 'height' => $height_max]);
    
        return $thumb_final;
    }

    function modifier_image($filename, $name_file_save, $folder_save, $width_max, $height_max) {
        list($width, $height, $type) = getimagesize($filename);
        if(type_valide($type)) {
            header('Content-Type: '.$type);
            save_image(image_resize($filename, $width_max, $height_max), $folder_save . DIRECTORY_SEPARATOR . $name_file_save, $type);
        }
    }

    function sauvegarder_image($filename, $name_file_save, $folder_save) {

        move_uploaded_file($filename, "$folder_save/$name_file_save");

    }

?>