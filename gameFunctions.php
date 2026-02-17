<?php
const MAX_ATTEMPTS = 6;
$_SESSION['attemptsLeft'] = $MAX_ATTEMPTS;
$_SESSION['guessedLetters'] = [];
$selectedLevel = $_POST['level'];
$_SESSION["selectedLevel"] = $selectedLevel;
$_SESSION["secretWord"] = getWord($selectedLevel);

$levelName = match($selectedLevel){
    '1' => 'facile',
    '2' => 'medio',
    '3' => 'difficile',
    'default' => 'sconosciuto',
};

?>