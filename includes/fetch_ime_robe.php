<?php

try {
    
    $queryImeRobe = "SELECT 
        ImeRobe.IdImeRobe, 
        ImeRobe.ImeRobe, 
        ImeRobe.VrstaRobeId, 
        VrstaRobe.ImeVrsteRobe AS VrstaRobeName
    FROM 
        ImeRobe
    LEFT JOIN 
        VrstaRobe 
    ON 
        ImeRobe.VrstaRobeId = VrstaRobe.IdVrstaRobe;";

    $stmtImeRobe = $pdo->prepare($queryImeRobe);
    $stmtImeRobe->execute();
    $rowsImeRobe = $stmtImeRobe->fetchAll(PDO::FETCH_ASSOC);

  

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}





