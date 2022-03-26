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

        public function __construct($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $user_type){
            $this->idUser = $idUser;
            $this->nickname = $nickname;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->name = $name;
            $this->phoneNumber = $phoneNumber;
            $this->pPicture = $pPicture;
            $this->bPicture = $bPicture;
            $this->user_type = $user_type;
        }

        public function updateUserSelf(){

           // TODO:
            if($this->checkUpdatedEmail($this->idUser, $this->email)){
                header("location: ../Pages/Perfil_usuario.php?error=userChecked");
                exit();
            }

            $this->Update($this->idUser, $this->nickname, $this->name, $this->pwd, $this->email, $this->phoneNumber, $this->pPicture, $this->bPicture, $this->user_type, $this->idUser);
        }

    }
?>