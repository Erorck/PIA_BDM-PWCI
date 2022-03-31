<?php
include"user.classes.php";

    class UserControler extends User{
        private $idUser;
        private $nickname;
        private $email;
        private $pwd;
        private $name;
        private $phoneNumber;
        private $pPicture;
        private $bPicture;
        private $user_type;
        private $updated_by;

        public function __construct(){
            
        }

        //Pseudocostructor que crea una instancia y la llena con el id dado
        public static function withUpdatedBy($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type, $updated_by){
            $instance = new self();
            $instance->fillUpdatedBy($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type, $updated_by);
            return $instance;
        }

        //Pseudocostructor que crea una instancia y la llena con la imagen dada
        public static function withUpdatedByThySelf($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type){
            $instance = new self();
            $instance->fillUpdatedByThySelf($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type);
            return $instance;

        }

        //Asigna un Id diferente a la columna de UPDATED_BY
        protected function fillUpdatedBy($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type, $updated_by){
            $this->idUser = $idUser;
            $this->nickname = $nickname;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->name = $name;
            $this->phoneNumber = $phoneNumber;
            $this->pPicture = $pPicture;
            $this->bPicture = $bPicture;
            $this->user_type = $user_type;
            $this->updated_by = $updated_by;
        }

        //Asigna su mismo Id a la columna de UPDATED_BY
        protected function fillUpdatedByThySelf($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type){
            $this->idUser = $idUser;
            $this->nickname = $nickname;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->name = $name;
            $this->phoneNumber = $phoneNumber;
            $this->pPicture = $pPicture;
            $this->bPicture = $bPicture;
            $this->user_type = $user_type;
            $this->updated_by = $idUser;
        }

        public function updateUser(){

           // TODO:
            if($this->checkUpdatedEmail($this->idUser, $this->email)){
                header("location: ../Pages/Perfil_usuario.php?error=userChecked");
                exit();
            }

            $this->Update($this->idUser, $this->nickname, $this->name, $this->pwd, $this->email, $this->phoneNumber, $this->pPicture, $this->bPicture, $this->user_type, $this->updated_by);
        }

        public function deleteUser(){ 
             $this->Delete($this->idUser, $this->updated_by);
         }

        public function setRegisteredUser(){ 
            $this->toRegisteredUser($this->idUser, $this->updated_by);
        }

        public function setJournalist(){ 
            $this->toJournalist($this->idUser, $this->updated_by);
        }

    }
?>