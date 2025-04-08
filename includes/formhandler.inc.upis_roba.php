<?php
include "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dropdown'], $_POST['RokUpotrebe'])) {
        $selectedOption = htmlspecialchars($_POST['dropdown']);
        $newInput1 = htmlspecialchars($_POST['RokUpotrebe']);
        $newInput2 = htmlspecialchars($_POST['DatumDolaska']);

        try {
            




            if($newInput1==NULL){
            $insertQuery = "INSERT INTO Roba (RokUpotrebe,DatumDolaska,ImeRobeId) VALUES (NULL,:DatumDolaska, :ImeRobeId)"; 
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':ImeRobeId', $selectedOption, PDO::PARAM_INT);
            $stmt->bindParam(':DatumDolaska', $newInput2, PDO::PARAM_STR);
            $stmt->execute();



            $pdo = null;
            $stmt = null;

             header("Location: ../upis-podataka.php");

             die();}

             else{

                $insertQuery = "INSERT INTO Roba (RokUpotrebe,DatumDolaska,ImeRobeId) VALUES (:RokUpotrebe,:DatumDolaska ,:ImeRobeId)"; 
                $stmt = $pdo->prepare($insertQuery);
                $stmt->bindParam(':ImeRobeId', $selectedOption, PDO::PARAM_INT);
                $stmt->bindParam(':RokUpotrebe', $newInput1, PDO::PARAM_STR);
                $stmt->bindParam(':DatumDolaska', $newInput2, PDO::PARAM_STR);
                $stmt->execute();
    
    
    
                $pdo = null;
                $stmt = null;
    
                 header("Location: ../upis-podataka.php");
    
                 die();
                
             }
           
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