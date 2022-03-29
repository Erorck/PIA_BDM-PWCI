<?php
include"consult.classes.php";

    class ConsultsControler extends Consults{


        public function getAllJournalists(){ 
             return $this->getJournalists();
         }

        public function getAllRUsers(){ 
             return $this->getRUsers();
         }

    }
?>