<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['loggedin']) ){
    header('Location: login.php');
    exit;
}
?>