<?php
include"../classes/Register/register.classes.php";

    class RegisterControler extends Register{
        private $name;
        private $email;
        private $pwd;
        private $user_type;

        public function __construct($name, $email, $pwd, $user_type){
            $this->name = $name;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->user_type = $user_type;
        }

        public function registerUser(){


            // if($this->emptyInputs() == false){
            //     header("location: ../index.php?error=emptyInput");
            //     exit();
            // }
            // if($this->matchPwd() == false){
            //     header("location: ../index.php?error=pwddoesntmatch");
            //     exit();
            // }
            if($this->checkUser($this->email)){
                header("location: ../Pages/Crear_Usuario.php?error=userChecked");
                exit();
            }

            $this->register($this->name, $this->email, $this->pwd, $this->user_type);
        }


        private function matchPwd(){
            $result = false;

            if($this->pwd !== $this->cpwd){
                $result = false;
            }else{
                $result = true;
            }
            
            return $result;
        }

        private function emptyInputs(){
            $result = false;

            if(empty($this->email) || empty($this->pwd) || empty($this->cpwd)){
                $result = false;
            } else {
                $result = true;
            }

            return $result;
        }
    }
?>