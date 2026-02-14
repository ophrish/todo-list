<?php

 $db_servername = "localhost";
 $db_username = "root";
 $db_password = "";
 $db_name = "todo";
 $conn ="";

 try{
 $conn=mysqli_connect($db_servername, $db_username, $db_password, $db_name);
}
catch(mysqli_sql_exception ){

    echo"CONNECTION FAILED" ;
}

?>