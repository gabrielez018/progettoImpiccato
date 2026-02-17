<?php

const MAX_ATTEMPTS = 6;

// Inizializzazione gioco
function inizialiseGame (){
    // Se arrivi direttamente da index
    if (isset($_POST['level'])) {
        startNewGame($_POST['level']);
        header("Location: game.php");
        exit;
    }

    // Se arrivi dal pulsante ritenta
    if (isset($_POST['new_game']) && isset($_SESSION['selectedLevel'])) {
        startNewGame($_SESSION['selectedLevel']);
        header("Location: game.php");
        exit;
    }

    // Se fai cambia livello
    if (isset($_POST['select_level'])) {
        resetGame();
        header("Location: index.php");
        exit;
    }
}

function startNewGame ($level){
    $_SESSION['selectedLevel'] = $level;
    $_SESSION["secretWord"] = getWord($level);
    $_SESSION['attemptsLeft'] = MAX_ATTEMPTS;
    $_SESSION['guessedLetters'] = [];
    $_SESSION['displayChars'] = array_fill(0, mb_strlen($_SESSION["secretWord"]), '_');
    $_SESSION['displayWord'] = implode(' ', $_SESSION['displayChars']);
    $_SESSION['gameOver'] = false;
    $_SESSION['win'] = false;
}

function resetGame(): void {
    unset(
        $_SESSION['selectedLevel'],
        $_SESSION['secretWord'],
        $_SESSION['attemptsLeft'],
        $_SESSION['guessedLetters'],
        $_SESSION['displayChars'],
        $_SESSION['displayWord'],
        $_SESSION['gameOver'],
        $_SESSION['win']
    );
}

inizialiseGame();

if (!isset($_SESSION['selectedLevel'])) {
    header("Location: index.php"); 
    exit;
}

// ----------------------------- Inizio pagina pulita

$levelName = match($_SESSION["selectedLevel"]){
    '1' => 'facile',
    '2' => 'medio',
    '3' => 'difficile',
    'default' => 'sconosciuto',
};

// Variabili locali
$selectedLevel = $_SESSION["selectedLevel"];
$secretWord = $_SESSION["secretWord"];
$attemptsLeft = $_SESSION['attemptsLeft'];
$guessedLetters = $_SESSION['guessedLetters'];
$displayWord = $_SESSION['displayWord'];

$errors = MAX_ATTEMPTS - $_SESSION['attemptsLeft'];
$gameOver = $_SESSION['gameOver'] ?? false;
$win = $_SESSION['win'] ?? false;


?>