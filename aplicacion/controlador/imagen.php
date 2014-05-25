	
<?php

class Imagen {

    var $nombreImagen;
    var $extensionImagen;

    function hacerMiniatura($src, $nombre, $longitud, $desired_width) {//$extension
        $extension = 'jpg';
        $thumb = new easyphpthumbnail;
        $thumb->Thumbheight = $desired_width;
        $thumb->Thumbwidth = $desired_width;
        $thumb->Thumblocation = 'imagenes/';
        $thumb->Thumbprefix = '';
        $thumb->Thumbsaveas = $extension;
        $thumb->Thumbfilename = $nombre . $longitud . $extension;
        $thumb->Createthumb($src, 'file');
    }

    function guardarImagen($codigoProd) {
        $allowedExts = array("jpeg", "jpg", "gif", "png");
        $allowedTypes = array("image/jpeg", "image/jpg", "image/pjpeg", "image/gif", "image/x-png", "image/png");
        if ($_FILES['file']['size'] > 0) {
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = strtolower(end($temp));
            $type = strtolower($_FILES["file"]["type"]);
            if (in_array($type, $allowedTypes) && ($_FILES["file"]["size"] < 10000000) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Error ";
                } else {
                    $carpeta = "imagenes/";
                    $nombreIMG = $codigoProd . '.' . $extension;
                    $v = $carpeta . $nombreIMG;
                    $path_parts = pathinfo($v);
                    $nombre = $path_parts['dirname'] . '/' . $path_parts['filename'];
                    if (file_exists($carpeta . $_FILES["file"]["name"])) {
                        unlink($carpeta . $_FILES["file"]["name"]);
                        unlink($carpeta . $path_parts['filename'] . 'x400.' . $path_parts['extension']);
                        unlink($carpeta . $path_parts['filename'] . 'x200.' . $path_parts['extension']);
                        unlink($carpeta . $path_parts['filename'] . 'x50.' . $path_parts['extension']);
                    }

                    move_uploaded_file($_FILES["file"]["tmp_name"], $v);
                    $this->hacerMiniatura($v, $codigoProd, 'x400.', 400);
                    $this->hacerMiniatura($v, $codigoProd, 'x200.', 200);
                    $this->hacerMiniatura($v, $codigoProd, 'x50.', 50);
                    $this->nombreImagen = $nombreIMG;
                    $this->extensionImagen = $extension;
                    echo "Exito";
                    return true;
                }
            } else {
                echo "Archivo invalido <br>";
                echo "Extension: " . $_FILES["file"]["type"] . ' y ' . $extension . " <br>";
                echo "tamanno: " . $_FILES["file"]["size"] . "<br>";
                echo "<a href=Configuracion.html>Volver</a>";
            }
        }
        echo "Fracaso";
        return false;
    }

    function getNombreImg() {
        return $this->nombreImagen;
    }

    function getExtensionImg() {
        return $this->extensionImagen;
    }

}
