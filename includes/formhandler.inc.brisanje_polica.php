<?php
include "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['oznaka'])) {
        $newInput = htmlspecialchars($_POST['oznaka']);

        try {
           
            $DeleteQuery = "DELETE FROM Polica WHERE Oznaka = :oznaka";
            $stmt = $pdo->prepare($DeleteQuery);
            
           
            $stmt->bindParam(':oznaka', $newInput, PDO::PARAM_STR);
            
            $stmt->execute();

            
            $pdo = null;
            $stmt = null;

            header("Location: ../brisanje-podataka.php");
            exit();
        } catch (PDOException $e) {
            echo "Error deleting data: " . $e->getMessage();
        }
    } else {
        echo "Please select an option and enter additional information.";
    }
} else {
    echo "Invalid request method.";
}

