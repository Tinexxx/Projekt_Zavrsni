<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
$vrsta_robe=$_POST["vrsta_robe"];


try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO VrstaRobe (ImeVrsteRobe) VALUES(:vrsta_robe);";  
    $stmt=$pdo->prepare($query);

    $stmt->bindParam(":vrsta_robe",$vrsta_robe);
    

    $stmt->execute();

   
    $pdo = null;
    $stmt = null;

    header("Location: ../upis-podataka.php");

    die();
} catch (PDOException $e) {
    die( "Query failed:  " .$e->getMessage());
}


} else{
    header("Location: ../index.php");
}