<?php
    require 'User.php';
    session_start();
?><!DOCTYPE html>
<html>
<head>
    <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#Logout').click(function() {
                $.ajax({
                    type: "POST",
                    url: "LogOut.php",
                    data: "action=logout",
                    success: function(msg){
                        alert(msg);
                        if(msg == "success"){
                            //cleared session
                            location.href="test.php";
                        }else{
                            //failed
                        }
                    },
                    error: function(msg){
                        alert('Error: cannot load page.');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <?php
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        echo "<p>".$_SESSION['DataUser']->USER_ALIAS."</p>";
        echo "<p>".$_SESSION['DataUser']->NAME."</p>";
        echo "<p>".$_SESSION['DataUser']->FIRST_LAST_NAME."</p>";
        echo "<p>".$_SESSION['DataUser']->SECOND_LAST_NAME."</p>";
        echo "<p>".$_SESSION['DataUser']->EMAIL."</p>";
        echo "<p>".$_SESSION['DataUser']->PHONE_NUMBER."</p>";
        echo "<p>".$_SESSION['DataUser']->BIRTHDAY."</p>";
        echo "<p>".$_SESSION['DataUser']->USER_TYPE."</p>";
        echo "<p> user is logged in </p>";
    }
    else 
    echo "<p> no user is logged in </p>";
    ?>
    <button id="Logout">cerrar session</button>
</body>
</html>