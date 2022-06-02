<?php
include "login.classes.php";

class LoginContr extends Login {

    private $email;
    private $pwd;

    public function __construct($email, $pwd){
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function loginUser(){
        // if($this->emptyInputs() == false){
        //     header("Location:../index.php?error=emptyInput");
        //     exit();
        // }

        $this->sign_in($this->email, $this->pwd);
    }

    private function emptyInputs(){
        $result = false;

        if(empty($this->email) || empty($this->pwd)){
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
}


?>