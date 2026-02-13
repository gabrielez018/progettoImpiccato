<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Load words into session if not already set. Prefer existing $_SESSION['words'] (set by level selection).
if (!isset($_SESSION['words']) || !is_array($_SESSION['words']) || empty($_SESSION['words'])) {
    $words = [];
    foreach (glob(__DIR__ . '/livelli/*.csv') as $csv) {
        $lines = file($csv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $w = trim($line);
            if ($w !== '') {
                $words[] = mb_strtoupper($w, 'UTF-8');
            }
        }
    }
    $_SESSION['words'] = $words;
}

// Basic game constants
$MAX_ATTEMPTS = 6;

// Initialize session fields if missing
if (!isset($_SESSION['attemptsLeft'])) {
    $_SESSION['attemptsLeft'] = $MAX_ATTEMPTS;
}
if (!isset($_SESSION['guessedLetters']) || !is_array($_SESSION['guessedLetters'])) {
    $_SESSION['guessedLetters'] = [];
}

// Pick a selected word if not set and words are available
if (!isset($_SESSION['selectedWord']) || $_SESSION['selectedWord'] === '') {
    if (!empty($_SESSION['words'])) {
        $sel = $_SESSION['words'][array_rand($_SESSION['words'])];
        $sel = mb_strtoupper(trim($sel), 'UTF-8');
        $_SESSION['selectedWord'] = $sel;
        $_SESSION['displayChars'] = array_fill(0, mb_strlen($sel), '_');
        $_SESSION['displayWord'] = implode(' ', $_SESSION['displayChars']);
        $_SESSION['attemptsLeft'] = $MAX_ATTEMPTS;
        $_SESSION['guessedLetters'] = [];
    } else {
        $_SESSION['selectedWord'] = '';
        $_SESSION['displayChars'] = [];
        $_SESSION['displayWord'] = '';
        $_SESSION['attemptsLeft'] = $MAX_ATTEMPTS;
        $_SESSION['guessedLetters'] = [];
    }
}

// Start a new game explicitly if requested
if (isset($_POST['new_game'])) {
    if (!empty($_SESSION['words'])) {
        $sel = $_SESSION['words'][array_rand($_SESSION['words'])];
        $sel = mb_strtoupper(trim($sel), 'UTF-8');
        $_SESSION['selectedWord'] = $sel;
        $_SESSION['displayChars'] = array_fill(0, mb_strlen($sel), '_');
        $_SESSION['displayWord'] = implode(' ', $_SESSION['displayChars']);
        $_SESSION['attemptsLeft'] = $MAX_ATTEMPTS;
        $_SESSION['guessedLetters'] = [];
    }
}

// Return to level selection
if (isset($_POST['select_level'])) {
    unset($_SESSION['level']);
    unset($_SESSION['selectedWord']);
    unset($_SESSION['displayChars']);
    unset($_SESSION['displayWord']);
    unset($_SESSION['attemptsLeft']);
    unset($_SESSION['guessedLetters']);
    unset($_SESSION['words']);
    header('Location: index.php');
    exit;
}

// Handle letter guess
if (isset($_POST['letter']) && !isset($_POST['new_game'])) {
    $input = trim((string)($_POST['letter'] ?? ''));
    if ($input !== '') {
        $letter = mb_strtoupper(mb_substr($input, 0, 1, 'UTF-8'), 'UTF-8');
        if (mb_strlen($letter, 'UTF-8') === 1 && preg_match('/\p{L}/u', $letter) && !in_array($letter, $_SESSION['guessedLetters'], true)) {
            $selectedWord = $_SESSION['selectedWord'];
            $wordLength = mb_strlen($selectedWord, 'UTF-8');
            $displayChars = is_array($_SESSION['displayChars']) ? $_SESSION['displayChars'] : array_fill(0, $wordLength, '_');
            $found = false;
            for ($j = 0; $j < $wordLength; $j++) {
                $ch = mb_substr($selectedWord, $j, 1, 'UTF-8');
                if ($ch === $letter) {
                    $displayChars[$j] = $letter;
                    $found = true;
                }
            }
            if ($found) {
                $_SESSION['displayChars'] = $displayChars;
                $_SESSION['displayWord'] = implode(' ', $displayChars);
            } else {
                $_SESSION['attemptsLeft']--;
            }
            $_SESSION['guessedLetters'][] = $letter;
        }
    }
}

$selectedWord = isset($_SESSION['selectedWord']) ? $_SESSION['selectedWord'] : '';
$displayWord = isset($_SESSION['displayWord']) ? $_SESSION['displayWord'] : '';
$attemptsLeft = isset($_SESSION['attemptsLeft']) ? $_SESSION['attemptsLeft'] : $MAX_ATTEMPTS;
$guessedLetters = isset($_SESSION['guessedLetters']) ? $_SESSION['guessedLetters'] : [];

$gameOver = false;
$win = false;
if ($displayWord !== '' && strpos($displayWord, '_') === false) {
    $gameOver = true;
    $win = true;
} elseif ($attemptsLeft <= 0) {
    $gameOver = true;
}
