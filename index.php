<?php
    require_once 'autorizathion.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>impiccato</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <body>
        <div>
            <h1>gioco dell'impiccato </h1>
            <h2>livelli disponibili</h2>
        </div>
        <div class="levels">
        <form action="game.php" method="POST">
            <?php

                require_once('tools.php');

                $levels = showLevel();

                if (!empty($levels)) {
                    echo "<div class='list-group mb-3'>"; 
                    
                    foreach ($levels as $index => $livello) {
                        echo "<div class='form-check'>";
                        
                        echo "  <input class='form-check-input' type='radio' name='level' id='lvl_$index' value='$livello' required>";
                        echo "  <label class='form-check-label' for='lvl_$index'> Livello $livello </label>";
                        
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary'>Inizia a giocare!</button>";
                }
            ?>
        </form>
    </div>
    
</body>
</html>
