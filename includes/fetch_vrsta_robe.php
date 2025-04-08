<?php


try {
   
   $queryVrstaRobe = "SELECT IdVrstaRobe, ImeVrsteRobe FROM VrstaRobe;";
   $stmtVrstaRobe = $pdo->prepare($queryVrstaRobe);
   $stmtVrstaRobe->execute();
   $rowsVrstaRobe = $stmtVrstaRobe->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   die("Database connection failed: " . $e->getMessage());
}