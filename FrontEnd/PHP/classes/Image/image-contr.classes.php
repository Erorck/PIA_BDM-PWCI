<?php
include "image.classes.php";

    class ImageContr extends Image{
        private $image;
        private $imageId;

        public function __construct(){}

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withId($imageId){
            $instance = new self();
            $instance->fillWithId($imageId);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withImage($image){
            $instance = new self();
            $instance->fillWithImage($image);
            return $instance;

        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithId($imageId){
            $this->imageId = $imageId;
        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithImage($image){
            $this->image = $image;
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        public function uploadImage(){
            $this->upload($this->image);
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        // public function uploadToUser(){
        //     $this->updateProfilePic($this->image);
        // }
        
        //Llamado a la funcion de la clase Image que obtiene la imagen de la base de datos
        public function retrieveImage(){
            $this->retrieve($this->imageId);
        }
    }
?>