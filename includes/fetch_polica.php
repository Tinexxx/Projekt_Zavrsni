<?php


try {
    $queryZauzete = "SELECT COUNT(*) AS Zauzete FROM Polica WHERE Zauzetost=0;";
    $querySlobodne = "SELECT COUNT(*) AS Slobodne FROM Polica WHERE Zauzetost=1;";

    $stmtZauzete = $pdo->prepare($queryZauzete);
    $stmtZauzete->execute();
    $rowsZauzete = $stmtZauzete->fetch(PDO::FETCH_ASSOC);

    $stmtSlobodne = $pdo->prepare($querySlobodne);
    $stmtSlobodne->execute();
    $rowsSlobodne = $stmtSlobodne->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>