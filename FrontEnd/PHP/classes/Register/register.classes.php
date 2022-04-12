<?php

include "../classes/dbh.classes.php";

class Register extends Dbh
{

    protected function register($name, $email, $password, $user_type)
    {
        //PREPARAMOS LA LLAMADA AL STORED PROCEDURE PARA INSERTAR EL USUARIO
        $stmt = $this->connect()->prepare('CALL sp_User("I", NULL, ?, ?, ?, ?, NULL, NULL, NULL, NULL, ?, 0);');
        //Codificamos la contraseña para la seguridad de su almacenamiento
        $hashPwd = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($name, $hashPwd, $name, $email, $user_type))) {
            //EN CASO DE FALLAR LA INSERCION, MOSTRAMOS LA PAGINA DE INCIO CON EL PARAMETRO DE ERROR
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        } else {
            //CASO CONTRARIO, OBTENEMOS AL RECIEN INSERTADO USUARIO
            $stmt2 = $this->connect()->prepare('CALL sp_User("SO", NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL);');

            if (!$stmt2->execute(array($email))) {
                //EN CASO DE FALLAR LA CONSULTA, MOSTRAMOS LA PAGINA DE INCIO CON EL PARAMETRO DE ERROR
                $stmt2 = null;
                header("location: ../Pages/Login.php?error=gettingUserFailded");
                exit();
            }

            if ($stmt2->rowCount() == 0) {
                //Verificamos que no venga vacia la consulta
                $stmt2 = null;
                header("location: ../Pages/Login.php?error=InsertedUserNotFound");
                session_start();
                $_SESSION["error"] = "userNotFound";
                exit();
            }
            
            $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);//Asignamos el usuario a un objeto
            session_start();
            //Iniciamos la sesión y asignamos las variables correspondientes
            $_SESSION["user"] = $users[0];
            $_SESSION["user_name"] = $users[0]["FULL_NAME"];
            $_SESSION["permission"] = $users[0]["USER_TYPE"];
            $_SESSION["HASH_CRED"] = $password;
            
            $stmt2 = null;//Rompemos toda conexion con la base de datos
        }

        $stmt = null;//Rompemos toda conexion con la base de datos
    }

    protected function checkUser($email)
    {
        $stmt = $this->connect()->prepare('CALL sp_User("SE", NULL, NULL, NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL);');
        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../Pages/Inicio.php?error=stmtFailed");
            exit();
        }
        $check = false;
        if ($stmt->rowCount() > 0) {
            $check = true;
            session_start();
            $_SESSION["error"] = "userChecked";
        } else {
            $check = false;
        }
        echo "$check";
        return $check;
    }
}
