<?php    
$dsn="mysql:host=localhost;dbname=u201042929_skladiste";
$dbusername="u201042929_admin";
$dbpassword="Novi_majur_treba_optiku1";


try{
$pdo= new PDO($dsn,$dbusername,$dbpassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
echo "Connection failed: "  . $e->getMessage();
}
