<?php
include "image.classes.php";

    class ImageContr extends Image{
        private $image;
        private $imageId;
        private $reportId;

        public function __construct(){}

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withId($imageId, $reportId){
            $instance = new self();
            $instance->fillWithId($imageId, $reportId);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withImage($image, $reportId){
            $instance = new self();
            $instance->fillWithImage($image, $reportId);
            return $instance;

        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithId($imageId, $reportId){
            $this->imageId = $imageId;
            $this->reportId = $reportId;
        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithImage($image, $reportId){
            $this->image = $image;
            $this->reportId = $reportId;
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        public function insert(){
            $this->insertImage($this->image, $this->reportId);
        }

        //Llamado a la funcion de la clase Image que elimina la imagen a la base de datos
        public function delete(){
            $this->deleteImage($this->imageId, $this->reportId);
        }

        
    }
?>