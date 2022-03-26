<?php
    include "../classes/Image/image-contr.classes.php";

    //Verificamos si se ha hecho el envio de un formulario con el boton load_image
    if (isset($_POST["load_image"])) {
        if (!empty($_FILES["image"]["name"])) { //Verificamos que si se haya subido un archivo
            $fileName = basename($_FILES["image"]["name"]); //Obtenemos el nombre de la imagen
            $imageType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); //Obtememos su extension
            $allowedTypes = array('jpg', 'png', 'gif'); //Creamos un arreglo de los tipos permitidos de extensiones

            if (in_array($imageType, $allowedTypes)) { //verificamos que la extension del archivo sea valida
                $imageName = $_FILES["image"]["tmp_name"]; //Obtenemos donde esta almacenada la imagen en si
                $base64Image = base64_encode(file_get_contents($imageName)); //La transformamos a base 64
                $realImage = 'data:image/' . $imageType . ";base64," . $base64Image; //concatemamos informacion adicional para la subidad a la BD

                ImageContr::withImage($realImage)->uploadImage(); //Utilizando un pseudoconstructor instanciamos una ImageContr y subimos la imagen

            } else { //caso contrario mostrarmos un mensaje de error
                header("Location: ../load.php?error=no_valid_extension");
                exit();
            }
        } else { //caso contrario mostrarmos un mensaje de error
            header("Location: ../load.php?error=no_file");
            exit();
        }

        header("Location: ../load.php?error=none");
        exit();
    }else if(isset($_POST["search_image"])){
        $imageId = $_POST["imageId"];
        ImageContr::withId($imageId)->retrieveImage();

        header("Location: ../search.php?error=none");
        exit();
    }

    if(isset($_POST["ajax_submit"])){    
        if (!empty($_FILES['upload_profile_pic']['name'])) { //Verificamos que si se haya subido un archivo
            $fileName = basename($_FILES["upload_profile_pic"]["name"]); //Obtenemos el nombre de la imagen
            $imageType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); //Obtememos su extension
            $allowedTypes = array('jpg', 'png', 'gif'); //Creamos un arreglo de los tipos permitidos de extensiones

            if (in_array($imageType, $allowedTypes)) { //verificamos que la extension del archivo sea valida
                $imageName = $_FILES["upload_profile_pic"]["tmp_name"]; //Obtenemos donde esta almacenada la imagen en si
                $base64Image = base64_encode(file_get_contents($imageName)); //La transformamos a base 64
                $realImage = 'data:image/' . $imageType . ";base64," . $base64Image; //concatemamos informacion adicional para la subidad a la BD

                ImageContr::withImage($realImage)->uploadImage(); //Utilizando un pseudoconstructor instanciamos una ImageContr y subimos la imagen

            } else { //caso contrario mostrarmos un mensaje de error
                echo "Extension no valida";
               // header("Location: ../load.php?error=no_valid_extension");
                exit();
            }
        } else { //caso contrario mostrarmos un mensaje de error
            echo "Archivo vacio";
            //header("Location: ../load.php?error=no_file");
            exit();
        }
        echo json_encode($realImage);
    }

?>