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
?>
