<?php
	require_once('authorization.php');

	if (!isset($authorized) || $authorized !== true) {
		header('Location: login.php');
		exit;
	}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>impiccato</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">


</head>
    <body>
		<?php
			require_once('header.php');
		?>
		
        <div class="content">
            <div>
                <h1>impiccato </h1>
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
        </div>
        
    
    </body>
</html>
