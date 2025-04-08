<?php
include "dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dropdown1'],$_POST['dropdown2'],$_POST['dropdown3'],$_POST['oznaka'])) {
        $selectedOption1 = htmlspecialchars($_POST["dropdown1"]);
        $selectedOption2 = htmlspecialchars($_POST["dropdown2"]);
        $selectedOption3 = htmlspecialchars($_POST["dropdown3"]);
        $newInput = htmlspecialchars($_POST['oznaka']);

        try {
            if($selectedOption2!=1){
            $insertQuery = "INSERT INTO Polica (Oznaka,Zauzetost,ZakupacId,RobaId,VelicinaPoliceId) VALUES (:Oznaka, 1, :ZakupacId , :RobaId , :VelicinaPoliceId)"; 
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':ZakupacId', $selectedOption1, PDO::PARAM_INT);
            $stmt->bindParam(':RobaId', $selectedOption2, PDO::PARAM_INT);
            $stmt->bindParam(':VelicinaPoliceId', $selectedOption3, PDO::PARAM_INT);
            $stmt->bindParam(':Oznaka',$newInput,PDO::PARAM_STR);
            
            $stmt->execute();

    $pdo = null;
    $stmt = null;

    header("Location: ../upis-podataka.php");

    die();
}
elseif($selectedOption2==1){
   
        $insertQuery = "INSERT INTO Polica (Oznaka,Zauzetost,ZakupacId,RobaId,VelicinaPoliceId) VALUES (:Oznaka, 0, :ZakupacId , :RobaId , :VelicinaPoliceId)"; 
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':ZakupacId', $selectedOption1, PDO::PARAM_INT);
        $stmt->bindParam(':RobaId', $selectedOption2, PDO::PARAM_INT);
        $stmt->bindParam(':VelicinaPoliceId', $selectedOption3, PDO::PARAM_INT);
        $stmt->bindParam(':Oznaka',$newInput,PDO::PARAM_STR);
        
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



