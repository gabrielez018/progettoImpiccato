<?php
session_start();
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        if(saveUser($username,$password)){
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        }
        else{
            echo "utente gia esistente";
            header(Location: 'register.php');
        }
    }
}
header('Location: register.php');
?>