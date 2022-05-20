<?php
include "videos.classes.php";

    class VideoContr extends Video{
        private $video;
        private $videoId;
        private $reportId;

        public function __construct(){}

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withId($videoId, $reportId){
            $instance = new self();
            $instance->fillWithId($videoId, $reportId);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withVideo($video, $reportId){
            $instance = new self();
            $instance->fillWithVideo($video, $reportId);
            return $instance;

        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithId($videoId, $reportId){
            $this->videoId = $videoId;
            $this->reportId = $reportId;
        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithVideo($video, $reportId){
            $this->video = $video;
            $this->reportId = $reportId;
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        public function insert(){
            $this->insertVideo($this->video, $this->reportId);
        }

        //Llamado a la funcion de la clase Image que elimina la imagen a la base de datos
        public function delete(){
            $this->deleteVideo($this->videoId, $this->reportId);
        }

        
    }
?>