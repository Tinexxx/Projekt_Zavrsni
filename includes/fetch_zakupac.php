<?php


try {
    
    $queryImePrezimeZakupca = "SELECT * FROM Zakupac;";
    $stmtImePrezimeZakupca = $pdo->prepare($queryImePrezimeZakupca);
    $stmtImePrezimeZakupca->execute();
    $rowsImePrezimeZakupca = $stmtImePrezimeZakupca->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());

}