<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['polica_id'];
    $oznaka = $_POST['oznaka'];
    $zakupac_id = $_POST['zakupac_id'];
    $roba_id = $_POST['roba_id'];
    $velicina_id = $_POST['velicina_id'];
    $zauzetost = $_POST['zauzetost'];

    require_once 'dbh.inc.php';

    if(empty($id)) {
        header("Location: ../azuriranje-podataka.php?error=emptyinput");
        exit();
    }

    try {
        // Build dynamic SQL based on provided fields
        $sql = "UPDATE Polica SET ";
        $params = array();
        $fields = array();
        
        if(!empty($oznaka)) {
            $fields[] = "Oznaka = ?";
            $params[] = $oznaka;
        }
        
        if(isset($zakupac_id)) { // Can be NULL
            $fields[] = "ZakupacId = ?";
            $params[] = $zakupac_id !== '' ? $zakupac_id : null;
        }
        
        if(isset($roba_id)) { // Can be NULL
            $fields[] = "RobaId = ?";
            $params[] = $roba_id !== '' ? $roba_id : null;
        }
        
        if(!empty($velicina_id)) {
            $fields[] = "VelicinaPoliceId = ?";
            $params[] = $velicina_id;
        }
        
        if(isset($zauzetost)) {
            $fields[] = "Zauzetost = ?";
            $params[] = $zauzetost;
        }
        
        if(count($fields) > 0) {
            $sql .= implode(", ", $fields);
            $sql .= " WHERE IdPolica = ?";
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