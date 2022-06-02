<?php
include "news_ctgs.classes.php";

    class News_CategoriesContr extends News_Categories{
        private $categoryId;
        private $reportId;
        private $updated_by;

        public function __construct(){}

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withId($categoryId, $reportId, $updated_by){
            $instance = new self();
            $instance->fillWithId($categoryId, $reportId, $updated_by);
            return $instance;
        }

        
        //Asigna la el parametro al id de la imagen
        protected function fillWithId($categoryId, $reportId, $updated_by){
            $this->categoryId = $categoryId;
            $this->reportId = $reportId;
            $this->updated_by = $updated_by;
        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithName($categoryId){
            $this->categoryId = $categoryId;
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        public function insert(){
            $this->insertNews_Ctgs($this->categoryId, $this->reportId, $this->updated_by);
        }

        //Llamado a la funcion de la clase Image que elimina la imagen a la base de datos
        public function delete(){
            $this->deleteNews_Ctgs($this->categoryId, $this->reportId);
        }

        
    }
?>