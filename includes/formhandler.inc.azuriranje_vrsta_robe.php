<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['vrsta_id'];
    $naziv = $_POST['vrsta_robe'];

    require_once 'dbh.inc.php';

    if(empty($id) || empty($naziv)) {
        header("Location: ../azuriranje-podataka.php?error=emptyinput");
        exit();
    }

    try {
        $sql = "UPDATE VrstaRobe SET ImeVrsteRobe = ? WHERE IdVrstaRobe = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$naziv, $id]);
        
        header("Location: ../azuriranje-podataka.php?error=none");
        exit();
    } catch(PDOException $e) {
        header("Location: ../azuriranje-podataka.php?error=dberror");
        exit();
    }
} else {
    header("Location: ../azuriranje-podataka.php");
    exit();
}
?>