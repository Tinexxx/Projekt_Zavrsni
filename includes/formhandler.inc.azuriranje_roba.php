<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['roba_id'];
    $datum_dolaska = $_POST['DatumDolaska'];
    $rok_upotrebe = $_POST['RokUpotrebe'];
    $ime_robe_id = $_POST['ime_robe_id'];

    require_once 'dbh.inc.php';

    if(empty($id)) {
        header("Location: ../azuriranje-podataka.php?error=emptyinput");
        exit();
    }

    try {
        // Build dynamic SQL based on provided fields
        $sql = "UPDATE Roba SET ";
        $params = array();
        $fields = array();
        
        if(!empty($datum_dolaska)) {
            $fields[] = "DatumDolaska = ?";
            $params[] = $datum_dolaska;
        }
        
        if(!empty($rok_upotrebe)) {
            $fields[] = "RokUpotrebe = ?";
            $params[] = $rok_upotrebe;
        }
        
        if(!empty($ime_robe_id)) {
            $fields[] = "ImeRobeId = ?";
            $params[] = $ime_robe_id;
        }
        
        if(count($fields) > 0) {
            $sql .= implode(", ", $fields);
            $sql .= " WHERE IdRoba = ?";
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