<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
$ime=$_POST["ime"];
$prezime=$_POST["prezime"];
$kontakt=$_POST["kontakt"];
$adresa=$_POST["adresa"];

try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO Zakupac (ime,prezime,kontakt,adresa,BrojIznajmljenihPolica) VALUES(:ime,:prezime,:kontakt,:adresa,0);";  
    $stmt=$pdo->prepare($query);

    $stmt->bindParam(":ime",$ime);
    $stmt->bindParam(":prezime",$prezime);
    $stmt->bindParam(":kontakt",$kontakt);
    $stmt->bindParam(":adresa",$adresa);

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