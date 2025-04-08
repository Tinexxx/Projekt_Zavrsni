<?php


try {
    
    $querySve = "
    SELECT DISTINCT
        Roba.IdRoba, 
        Roba.RokUpotrebe, 
        Roba.DatumDolaska,
        ImeRobe.ImeRobe, 
        Zakupac.Ime, 
        Zakupac.Prezime,
        Zakupac.Kontakt,
        VelicinaPolice.Cijena
        
    FROM Roba
    LEFT JOIN ImeRobe ON Roba.ImeRobeId = ImeRobe.IdImeRobe
    LEFT JOIN VelicinaPolice ON Roba.ImeRobeId = VelicinaPolice.IdVelicinaPolice
    LEFT JOIN Polica ON Polica.RobaId = Roba.IdRoba
    LEFT JOIN Zakupac ON Polica.ZakupacId = Zakupac.IdZakupac;";

    $stmtSve = $pdo->prepare($querySve);
    $stmtSve->execute();
    $rowsSve = $stmtSve->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}