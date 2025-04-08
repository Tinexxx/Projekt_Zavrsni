<?php
include "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dropdown1'])) {
        $SelectedOption = htmlspecialchars($_POST['dropdown1']);

        try {
           
            $DeleteQuery = "DELETE FROM Zakupac WHERE IdZakupac=:idzakupac";
            $stmt = $pdo->prepare($DeleteQuery);
            
           
            $stmt->bindParam(':idzakupac', $SelectedOption, PDO::PARAM_STR);
            
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
