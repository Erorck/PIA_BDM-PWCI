<?php
include "consult.classes.php";

    class ConsultsControler extends Consults{


        public function getAllJournalists(){ 
             return $this->getJournalists();
         }

        public function getAllRUsers(){ 
             return $this->getRUsers();
         }

         public function getJournalistNews($journalistId){ 
            return $this->getNewsFromJournalist($journalistId);         
        }

         public function getNewsForRevision(){ 
            return $this->getNewsForEditor();         
        }         

        public function getAllNewsPublished(){
            return $this->getAllNews();
        }

        public function getSearchedNews($querySearch, $dateMin, $dateMax){
            return $this->getSearchedNewsWithFilters($querySearch, $dateMin,$dateMax);
        }

        public function getReportById($reportId){ 
            return $this->getReport($reportId);         
        }

        public function getLReport($oper, $fechamin, $fechamax, $categoryId){ 
            return $this->getLikesReport($oper, $fechamin, $fechamax, $categoryId);         
        }

        public function getASections(){ 
             return $this->getAllActiveSections();         
        }

        public function getESections(){ 
             return $this->getAllEliminatedSections();
        }

        public function getATags(){ 
            return $this->getAllTags();         
        }

        public function getReportCtgs($reportId){ 
            return $this->retrieveAllCtgsFromReport($reportId);         
        }

        public function getReportTags($reportId){ 
            return $this->retrieveAllTagsFromReport($reportId);         
        }

        public function getReportVideos($reportId){ 
            return $this->retrieveAllVideosFromReport($reportId);         
        }

        public function getReportImages($reportId){ 
            return $this->retrieveAllImagesFromReport($reportId);         
        }

        public function getCommentsByReportId($reportId){    
            return $this->getCommentsByReport($reportId);
        }

    }
?>