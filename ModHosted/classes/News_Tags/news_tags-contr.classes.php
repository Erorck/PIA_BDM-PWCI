<?php
include "news_tags.classes.php";

    class News_TagsContr extends News_Tags{
        private $tag;
        private $reportId;
        private $updated_by;

        public function __construct(){}

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withId($tag, $reportId, $updated_by){
            $instance = new self();
            $instance->fillWithId($tag, $reportId, $updated_by);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withName($tag){
            $instance = new self();
            $instance->fillWithName($tag);
            return $instance;

        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithId($tag, $reportId, $updated_by){
            $this->tag = $tag;
            $this->reportId = $reportId;
            $this->updated_by = $updated_by;
        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithName($tag){
            $this->tag = $tag;
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        public function insert(){
            $this->insertNews_Tags($this->tag, $this->reportId, $this->updated_by);
        }

        //Llamado a la funcion de la clase Image que elimina la imagen a la base de datos
        public function delete(){
            $this->deleteNewsTags($this->tag, $this->reportId);
        }

        
    }
?>