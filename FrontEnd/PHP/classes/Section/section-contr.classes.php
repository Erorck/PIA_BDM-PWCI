<?php
include "section.classes.php";

    class SectionControler extends Section{
        private $idCategory;
        private $name;
        private $color;
        private $order;       
        private $updated_by;

        public function __construct(){
            
        }

        //Pseudocostructor que crea una instancia y la llena con el nombre dado
        public static function withName( $name, $color, $order, $updated_by){
            $instance = new self();
            $instance->fillWithName( $name, $color, $order, $updated_by);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withId($idCategory, $name, $color, $order, $updated_by){
            $instance = new self();
            $instance->fillWithId($idCategory, $name, $color, $order, $updated_by);
            return $instance;
        }

        
        protected function fillWithName($name, $color, $order, $updated_by){
            $this->name = $name;
            $this->color = $color;
            $this->order = $order;           
            $this->updated_by = $updated_by;
        }

        protected function fillWithId($idCategory, $name, $color, $order, $updated_by){
            $this->idCategory = $idCategory;
            $this->name = $name;
            $this->color = $color;
            $this->order = $order;           
            $this->updated_by = $updated_by;
        }

        public function updateSection(){
            $this->Update($this->idCategory, $this->name, $this->color, $this->order, $this->updated_by);
        }

        public function updateSectionName(){
            $this->UpdateName($this->idCategory, $this->name, $this->updated_by);
        }

        public function insertSection(){
            $this->Insert($this->name, $this->color, $this->order, $this->updated_by);
        }

        public function nameIsAvailable(){
            if(!$this->checkUpdatedName($this->idCategory, $this->name)){
               return true;
            }else{
                return false;
            }
        
        }

        public function deleteSection(){ 
             $this->modStatus("E", $this->idCategory, $this->updated_by);
        }

        public function activateSection(){ 
            $this->modStatus("H", $this->idCategory, $this->updated_by);
        }

    }
?>