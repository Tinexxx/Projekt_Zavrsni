<?php


try {
    
    $queryImeVelicine = "SELECT IdVelicinaPolice, ImeVelicinaPolice,Cijena FROM VelicinaPolice;";
    $stmtImeVelicine = $pdo->prepare($queryImeVelicine);
    $stmtImeVelicine->execute();
    $rowsImeVelicine = $stmtImeVelicine->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

