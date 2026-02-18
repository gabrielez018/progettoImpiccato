<?php
function getLevels()
{
    if (!is_dir("livelli")) {
        return;
    }
    $d = dir("livelli");
    $levels = [];
    while (false !== ($entry = $d->read())) {
        if ($entry == "." || $entry == "..") {
            continue;
        }
        $position = strpos($entry, ".");
        $levels[] = substr($entry, 0, $position);
    }
    $d->close();
    return $levels;
}



function getWord($level)
{
    $path = "livelli/" . $level . ".csv";
    if (file_exists($path)) {
        $file = fopen($path, "r");
    } else {
        return;
    }
    $allWords = [];
    while (($data = fgetcsv($file, 1000, ",")) !== false) {
        foreach ($data as $word) {
            $cleanedWord = trim($word);
            if (!empty($cleanedWord)) {
                $allWords[] = $cleanedWord;
            }
        }
    }
    if (!empty($allWords)) {
        $index = array_rand($allWords);
        return $allWords[$index];
    } else {
        return;
    }
}
