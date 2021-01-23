<?php

$serverName = "localhost";
$usename = "root";
$password = "";
$dbname = "security_project";

$conn = new PDO("mysql:host=$serverName;dbname=$dbname",$usename,$password);



  if(!$conn)
  {
    echo "Connection Error";
  }
  else{
    }

?>