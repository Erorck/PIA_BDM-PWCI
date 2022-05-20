<?php
include"consult.classes.php";

    class ConsultsControler extends Consults{


        public function getAllJournalists(){ 
             return $this->getJournalists();
         }

        public function getAllRUsers(){ 
             return $this->getRUsers();
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

    }
?>