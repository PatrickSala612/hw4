<?php
$host = "localhost";
$dbName = "cweb1113";
$userName = "root";
$password = "";

try {
  $con = new PDO("mysql:host={$host};dbname={$dbName}",$userName,$password);
  //echo "Connection Good";
}

catch (Exception $e){
  echo "Connection Error:".$e->getMessage();
}
?>