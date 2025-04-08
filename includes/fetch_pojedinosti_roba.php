<?php



try {
    $queryRobaPojedinosti = "
        SELECT Roba.IdRoba, Roba.RokUpotrebe, ImeRobe.ImeRobe
        FROM Roba
        INNER JOIN ImeRobe ON Roba.ImeRobeId = ImeRobe.IdImeRobe;
    ";
    $stmtRobaPojedinosti = $pdo->prepare($queryRobaPojedinosti);
    $stmtRobaPojedinosti->execute();
    $rowsRobaPojedinosti = $stmtRobaPojedinosti->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}