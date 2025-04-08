<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['zakupac_id'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $kontakt = $_POST['kontakt'];
    $adresa = $_POST['adresa'];

    require_once 'dbh.inc.php';

    if(empty($id)) {
        header("Location: ../azuriranje-podataka.php?error=emptyinput");
        exit();
    }

    try {
        // Build dynamic SQL based on provided fields
        $sql = "UPDATE Zakupac SET ";
        $params = array();
        $fields = array();
        
        if(!empty($ime)) {
            $fields[] = "Ime = ?";
            $params[] = $ime;
        }
        
        if(!empty($prezime)) {
            $fields[] = "Prezime = ?";
            $params[] = $prezime;
        }
        
        if(!empty($kontakt)) {
            $fields[] = "Kontakt = ?";
            $params[] = $kontakt;
        }
        
        if(!empty($adresa)) {
            $fields[] = "Adresa = ?";
            $params[] = $adresa;
        }
        
        if(count($fields) > 0) {
            $sql .= implode(", ", $fields);
            $sql .= " WHERE IdZakupac = ?";
            $params[] = $id;
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            header("Location: ../azuriranje-podataka.php?error=none");
            exit();
        } else {
            header("Location: ../azuriranje-podataka.php?error=nofields");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: ../azuriranje-podataka.php?error=dberror");
        exit();
    }
} else {
    header("Location: ../azuriranje-podataka.php");
    exit();
}
?>