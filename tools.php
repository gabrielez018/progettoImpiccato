<?php
declare(strict_types=1);

    /**
     * tools.php
     * Utility functions for the Hangman game.
     */

    /**
     * Return an array of level filenames (without extension) from the `livelli` directory.
     *
     * @return string[]
     */
    function get_levels(): array
    {
        $dir = __DIR__ . '/livelli';
        if (!is_dir($dir)) {
            return [];
        }

        $files = scandir($dir);
        $levels = [];

        foreach ($files as $f) {
            if ($f === '.' || $f === '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $f;
            if (!is_file($path)) {
                continue;
            }
            $ext = pathinfo($f, PATHINFO_EXTENSION);
            if (strtolower($ext) !== 'csv') {
                continue;
            }
            $name = pathinfo($f, PATHINFO_FILENAME);
            $levels[] = $name;
        }

        sort($levels, SORT_NATURAL | SORT_FLAG_CASE);
        return array_values($levels);
    }

    /**
     * Read words for a given level from a CSV file and return an array of uppercase trimmed words.
     *
     * @param string $level
     * @return string[]
     */
    function get_words_for_level(string $level): array
    {
        // sanitize level to allow only simple filename chars
        $safeLevel = preg_replace('/[^a-zA-Z0-9_-]/u', '', $level);
        if ($safeLevel === '') {
            return [];
        }

        $file = __DIR__ . '/livelli/' . $safeLevel . '.csv';
        if (!is_file($file) || !is_readable($file)) {
            return [];
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return [];
        }

        $words = [];
        foreach ($lines as $line) {
            $cols = str_getcsv($line);
            if (!is_array($cols) || count($cols) === 0) {
                continue;
            }
            $raw = trim((string)$cols[0]);
            if ($raw === '') {
                continue;
            }
            $upper = mb_strtoupper($raw, 'UTF-8');
            $words[] = $upper;
        }

        return array_values($words);
    }

    ?>