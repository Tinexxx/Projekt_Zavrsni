<?php
header('Content-Type: application/json');

// Database connection (your existing code)
$dsn = "mysql:host=localhost;dbname=u201042929_skladiste";
$dbusername = "u201042929_admin";
$dbpassword = "Novi_majur_treba_optiku1";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Main query (your original query structure)
    $query = "
    SELECT 
        Polica.Oznaka as shelf_id,
        Polica.IdPolica,
        Roba.IdRoba, 
        DATE_FORMAT(Roba.RokUpotrebe, '%Y-%m-%d %H:%i:%s') as RokUpotrebe,
        DATE_FORMAT(Roba.DatumDolaska, '%Y-%m-%d %H:%i:%s') as DatumDolaska,
        ImeRobe.ImeRobe, 
        Zakupac.Ime, 
        Zakupac.Prezime,
        Zakupac.Kontakt,
        VelicinaPolice.Cijena,
        VelicinaPolice.ImeVelicinaPolice
    FROM Polica
    LEFT JOIN Roba ON Polica.RobaId = Roba.IdRoba
    LEFT JOIN ImeRobe ON Roba.ImeRobeId = ImeRobe.IdImeRobe
    LEFT JOIN VelicinaPolice ON Polica.VelicinaPoliceId = VelicinaPolice.IdVelicinaPolice
    LEFT JOIN Zakupac ON Polica.ZakupacId = Zakupac.IdZakupac";

    // Shelf filtering
    if (isset($_GET['shelf_id'])) {
        $query .= " WHERE Polica.Oznaka = :shelfId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':shelfId', $_GET['shelf_id'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo $result ? json_encode($result) : json_encode(["error" => "Shelf not found"]);
    } else {
        // Return all shelves if no filter
        $stmt = $pdo->query($query);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

} catch(PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}