<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ime_id'];
    $ime = $_POST['ime_robe'];
    $vrsta_id = $_POST['vrsta_id'];

    require_once 'dbh.inc.php';

    if(empty($id)) {
        header("Location: ../azuriranje-podataka.php?error=emptyinput");
        exit();
    }

    try {
        // Build dynamic SQL based on provided fields
        $sql = "UPDATE ImeRobe SET ";
        $params = array();
        $fields = array();
        
        if(!empty($ime)) {
            $fields[] = "ImeRobe = ?";
            $params[] = $ime;
        }
        
        if(!empty($vrsta_id)) {
            $fields[] = "VrstaRobeId = ?";
            $params[] = $vrsta_id;
        }
        
        if(count($fields) > 0) {
            $sql .= implode(", ", $fields);
            $sql .= " WHERE IdImeRobe = ?";
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