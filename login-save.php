<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';

	if (verifyPassword($username, $password)) {
		$_SESSION['username'] = $username;
		header('Location: index.php');
		exit;
	} else {
		header('Location: login.php?error=1');
		exit;
	}
}

header('Location: login.php');
