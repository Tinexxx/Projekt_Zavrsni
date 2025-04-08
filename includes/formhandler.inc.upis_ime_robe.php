<?php
include "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dropdown'], $_POST['ImeRobe'])) {
        $selectedOption = htmlspecialchars($_POST["dropdown"]);
        $newInput = htmlspecialchars($_POST['ImeRobe']);

        try {
            
            $insertQuery = "INSERT INTO ImeRobe (ImeRobe,VrstaRobeId) VALUES (:ImeRobe, :VrstaRobeId)"; 
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':VrstaRobeId', $selectedOption, PDO::PARAM_INT);
            $stmt->bindParam(':ImeRobe', $newInput, PDO::PARAM_STR);
            $stmt->execute();

            $pdo = null;
            $stmt = null;
        
            header("Location: ../upis-podataka.php");
        
            die();
           
        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    } else {
        echo "Please select an option and enter additional information.";
    }
} else {
    echo "Invalid request method.";
}
?>