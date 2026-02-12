<?php
session_start();

if (!isset($_SESSION['words']) || empty($_SESSION['words'])) {
    $words = [];
    $i = 1;
    while (true) {
        $filename = "parole{$i}.txt";
        if (!file_exists($filename)) {
            break;
        }
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $words = array_merge($words, $lines);
        $i++;
    }
    if (empty($words)) {
        die("Nessun file parole trovato.");
    }
    $_SESSION['words'] = $words;
}
    if (isset($_POST['new_game'])) {
    $_SESSION['selectedWord'] = $_SESSION['words'][array_rand($_SESSION['words'])];
    $_SESSION['displayWord'] = str_repeat('_ ', strlen($_SESSION['selectedWord']));
    $_SESSION['attemptsLeft'] = 6;
    $_SESSION['guessedLetters'] = '';
}

if (isset($_POST['letter']) && !isset($_POST['new_game'])) {
    $letter = strtoupper(trim($_POST['letter'])[0]);
    if (strlen($letter) === 1 && ctype_alpha($letter) && strpos($_SESSION['guessedLetters'], $letter) === false) {
        $selectedWord = $_SESSION['selectedWord'];
        $wordLength = strlen($selectedWord);
        $displayArray = str_split($_SESSION['displayWord']);
        
        if (strpos($selectedWord, $letter) !== false) {
            for ($j = 0; $j < $wordLength; $j++) {
                if ($selectedWord[$j] === $letter) {
                    $displayArray[2 * $j] = $letter;
                }
            }
            $_SESSION['displayWord'] = implode('', $displayArray);
        } else {
            $_SESSION['attemptsLeft']--;
        }
        $_SESSION['guessedLetters'] .= $letter;
    }
}

?>

