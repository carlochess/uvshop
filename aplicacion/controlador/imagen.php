	
<?php
	
	class Imagen
	{
		var $nombreImagen;
		function hacerMiniatura($src, $dest, $desired_width) {

			$source_image = imagecreatefromjpeg($src);
			$width = imagesx($source_image);
			$height = imagesy($source_image);
			
			$desired_height = $desired_width;
			
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
			
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			
			imagejpeg($virtual_image, $dest);
		}
		
		function guardarImagen()
		{
			if ($_FILES['file']['size']>0 )
			{
				$allowedExts = array("jpeg", "jpg");//"gif", "png"
				$allowedTypes = array("image/jpeg", "image/jpg","image/pjpeg");//"image/gif","image/x-png","image/png"
				$temp = explode(".", $_FILES["file"]["name"]);
				$extension = end($temp);
				$type = $_FILES["file"]["type"];
				if (in_array($type, $allowedTypes) && ($_FILES["file"]["size"] < 1000000) && in_array($extension, $allowedExts))
				{
					if ($_FILES["file"]["error"] > 0)
					{
						echo "Error ";
					}
					else
					{
						$carpeta = "imagenes/";
						$nombreIMG = $_FILES["file"]["name"];
						$v = $carpeta.$nombreIMG ;
						$path_parts = pathinfo($v);
						$nombre = $path_parts['dirname'].'/'.$path_parts['filename'];
						if (file_exists($carpeta. $_FILES["file"]["name"]))
						{
							unlink($carpeta. $_FILES["file"]["name"]);
							unlink($carpeta. $path_parts['filename'].'x400.'.$path_parts['extension']);
							unlink($carpeta. $path_parts['filename'].'x200.'.$path_parts['extension']);
							unlink($carpeta. $path_parts['filename'].'x50.'.$path_parts['extension']);
						}
						
						move_uploaded_file($_FILES["file"]["tmp_name"],$v );
						
						$this->hacerMiniatura($v ,$nombre.'x400.'.$path_parts['extension'], 400);
						$this->hacerMiniatura($v ,$nombre.'x200.'.$path_parts['extension'], 200);
						$this->hacerMiniatura($v ,$nombre.'x50.'.$path_parts['extension'], 50);
						$this->nombreImagen = $path_parts['filename'];
						//echo "Imagen creada";
						return true;
					}
				}
				else
				{
				    echo "Archivo invalido <br>";
					echo "Extension: ".$_FILES["file"]["type"]." <br>";
					echo "tamanno: ".$_FILES["file"]["size"]."<br>";
					echo "<a href=Configuracion.html>Volver</a>";
				}
			}
			return false;
		}
		function getNombreImg()
		{
			return $this->nombreImagen;
		}
		
	}
?>