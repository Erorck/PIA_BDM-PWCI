<?php

Class Dbh{//Clase que se encarga de la conexion a la base de datos

    protected function connect(){ //metodo de conexion que retorna la conexión
        try{
            //Parametros necesairos para realizar la conexión 
            $server = "localhost";
            $username = "root";
            $password = "root";
            $database = "good_old_times_db";

            $conn = new PDO("mysql:host=$server;dbname=$database",$username,$password); //Utilizando la clase Php Data Object creamos una conexión
            return $conn;//retornamos dicha conexión 
        }   
        catch(PDOException $error){
            die("Connection failed ". $error->getMessage()); //Mensaje de error en caso de que la conexión falle
        } 
    }
}

?>