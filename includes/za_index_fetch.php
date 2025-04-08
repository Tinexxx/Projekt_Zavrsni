<?php 

try {
        $sqlPolica = "SELECT p.IdPolica, p.Oznaka, v.ImeVelicinaPolice, 
                     z.Ime, z.Prezime, i.ImeRobe, r.RokUpotrebe, p.ZakupacId
                     FROM Polica p
                     LEFT JOIN VelicinaPolice v ON p.VelicinaPoliceId = v.IdVelicinaPolice
                     LEFT JOIN Zakupac z ON p.ZakupacId = z.IdZakupac
                     LEFT JOIN Roba r ON p.RobaId = r.IdRoba
                     LEFT JOIN ImeRobe i ON r.ImeRobeId = i.IdImeRobe";
        $stmtPolica = $pdo->prepare($sqlPolica);
        $stmtPolica->execute();
        $rowsPolica = $stmtPolica->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }