<?php
session_start();
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	$authorized = true;
	$current_user = $_SESSION['username'];
} else {
	$authorized = false;
	$current_user = null;
}
