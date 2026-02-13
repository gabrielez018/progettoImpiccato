<?php
const MAX_ATTEMPTS = 6;
$_SESSION['attemptsLeft'] = $MAX_ATTEMPTS;
$_SESSION['guessedLetters'] = [];
$_SESSION["secretWord"] = getWord($level);
$level = $_POST["level"];


?>