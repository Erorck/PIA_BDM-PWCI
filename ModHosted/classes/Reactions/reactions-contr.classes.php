
<?php
include "reactions.classes.php";

    class ReactionsContr extends Reactions{
        public $liked;
        public $reportId;
        public $updated_by;

        public function __construct(){}

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withId($updated_by, $reportId, $liked){
            $instance = new self();
            $instance->fillWithId($updated_by, $reportId, $liked);
            return $instance;
        }

        
        //Asigna la el parametro al id de la imagen
        protected function fillWithId($updated_by, $reportId, $liked){
            $this->updated_by = $updated_by;
            $this->reportId = $reportId;
            $this->liked = $liked;
        }
        
        //Asigna la el parametro al id de la imagen
        protected function fillWithName($liked){
            $this->liked = $liked;
        }

        //Llamado a la funcion de la clase Image que sube la imagen a la base de datos
        public function ManageReaction(){
            $this->insertReaction($this->updated_by, $this->reportId, $this->liked);
        }

        public function getReaction(){
          return $this->reactionValue($this->updated_by, $this->reportId);
        }

        public function getElements($updated_by, $reportId){
            return $updated_by.'-'.$reportId;
          }

        //Llamado a la funcion de la clase Image que elimina la imagen a la base de datos
        public function dislike(){
            $this->minusLike($this->liked, $this->reportId);
        }

        
    }
?>