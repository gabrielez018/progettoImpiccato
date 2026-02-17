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

    // Gestione del tentativo
    if (isset($_POST['letter'])) {
        checkGuess($_POST['letter']);
        header("Location: game.php"); 
        exit;
    }
}

function checkGuess($letter) {
    $letter = validateInput($letter);
    if (!$letter){
        return;
    }

    if ($_SESSION['gameOver'] || wasAlreadyGuessed($letter)) {
        return;
    }

    $_SESSION['guessedLetters'][] = $letter;

    $found = revealLetter($letter);

    updateGameStatus($found);
}

function validateInput($letter){
    $letter = trim($letter);

    if($letter === ''){
        return null;
    }

    return strtoupper($letter);
}

function wasAlreadyGuessed($letter){
    return in_array($letter,$_SESSION['guessedLetters']);
}

function revealLetter($letter){
    $found = false;
    $secretWord = $_SESSION['secretWord'];
    $wordLength = mb_strlen($secretWord);

    for ($i = 0; $i < $wordLength; $i++) {
        $charInWord = mb_substr($secretWord, $i, 1);
        
        if (strtoupper($charInWord) === $letter) {
            $_SESSION['displayChars'][$i] = $charInWord;
            $found = true;
        }
    }
    
    if ($found) {
        $_SESSION['displayWord'] = implode(' ', $_SESSION['displayChars']);
    }

    return $found;
}

function updateGameStatus($found) {
    if ($found) {
        // Controlla vincita
        if (!in_array('_', $_SESSION['displayChars'])) {
            $_SESSION['win'] = true;
            $_SESSION['gameOver'] = true;
        }
    } else {
        $_SESSION['attemptsLeft']--;

        // Controlla perdita
        if ($_SESSION['attemptsLeft'] <= 0) {
            $_SESSION['gameOver'] = true;
            $_SESSION['win'] = false;
        }
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