<?php

try{


$queryVelicinaPolica = "SELECT VelicinaPolice.ImeVelicinaPolice, COUNT(Polica.IdPolica) AS BrojPolica 
                            FROM VelicinaPolice 
                            LEFT JOIN Polica ON VelicinaPolice.IdVelicinaPolice = Polica.VelicinaPoliceId 
                            GROUP BY VelicinaPolice.ImeVelicinaPolice;";

    $stmtVelicinaPolica = $pdo->prepare($queryVelicinaPolica);
    $stmtVelicinaPolica->execute();
    $rowsVelicinaPolica = $stmtVelicinaPolica->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>