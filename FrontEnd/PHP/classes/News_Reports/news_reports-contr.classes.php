<?php
include "news_reports.classes.php";

    class News_ReportsControler extends News_Reports{
        private $id_ReportT;
        private $signT;
        private $streetT;
        private $neighbourhoodT;       
        private $cityT;       
        private $countryT;       
        private $event_date;       
        private $headerT;       
        private $descriptionT;       
        private $contentT;       
        private $thumbnailT;       
        private $updated_by;

        public function __construct(){
            
        }

        //Pseudocostructor que crea una instancia y la llena con el nombre dado
        public static function withInfo( $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){
            $instance = new self();
            $instance->fillWithInfo( $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withId($id_ReportT, $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){
            $instance = new self();
            $instance->fillWithId($id_ReportT, $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by);
            return $instance;
        }

        
        protected function fillWithInfo($signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){
            $this->signT = $signT;
            $this->streetT = $streetT;
            $this->neighbourhoodT = $neighbourhoodT;           
            $this->cityT = $cityT;           
            $this->countryT = $countryT;           
            $this->event_date = $event_date;           
            $this->headerT = $headerT;           
            $this->descriptionT = $descriptionT;           
            $this->contentT = $contentT;           
            $this->thumbnailT = $thumbnailT;        
            $this->updated_by = $updated_by;
        }

        protected function fillWithId($id_ReportT, $signT, $streetT, $neighbourhoodT, $cityT, $countryT, $event_date, $headerT, $descriptionT, $contentT, $thumbnailT, $updated_by){
            $this->id_ReportT = $id_ReportT;
            $this->signT = $signT;
            $this->streetT = $streetT;
            $this->neighbourhoodT = $neighbourhoodT;           
            $this->cityT = $cityT;           
            $this->countryT = $countryT;           
            $this->event_date = $event_date;           
            $this->headerT = $headerT;           
            $this->descriptionT = $descriptionT;           
            $this->contentT = $contentT;           
            $this->thumbnailT = $thumbnailT;        
            $this->updated_by = $updated_by;
        }
        
        public function insertNewsReport(){
            return $this->Insert($this->signT, $this->streetT, $this->neighbourhoodT, $this->cityT, $this->countryT, $this->event_date, $this->headerT, $this->descriptionT, $this->contentT, $this->thumbnailT, $this->updated_by);
        }

        public function updateNewsReport(){
            $this->Update($this->id_ReportT, $this->signT, $this->streetT, $this->neighbourhoodT, $this->cityT, $this->countryT, $this->event_date, $this->headerT, $this->descriptionT, $this->contentT, $this->thumbnailT, $this->updated_by);
        }

        public function deleteNewsReport(){ 
             $this->modStatus("DEL", $this->id_ReportT, $this->updated_by);
        }

      

        public function publicateNewsReport(){ 
            $this->modStatus("PUB", $this->id_ReportT, $this->updated_by);
        }

        public function sendToReporter(){ 
            $this->modStatus("STR", $this->id_ReportT, $this->updated_by);
        }

        public function sendToEditor(){ 
            $this->modStatus("STE", $this->id_ReportT, $this->updated_by);
        }

        public function plusOneLike(){ 
            $this->modStatus("+LIK", $this->id_ReportT, $this->updated_by);
        }

        public function minusOneLike(){ 
            $this->modStatus("-LIK", $this->id_ReportT, $this->updated_by);
        }

    }
?>