<?php
require_once 'authorization.php';
require_once 'tools.php';
require_once 'gameFunctions.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gioco dell'impiccato</title>
    <link rel="stylesheet" href="hangman.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>

    <?php
    require_once 'header.php';

    if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        echo $_SESSION["secretWord"];
    }
    ?>

    <div class="container mt-3">        
        <div class="top">
            <div><strong>Difficoltà:</strong> <?php echo htmlspecialchars($levelName); ?></div>
            <div class="text-center">
                <h3>Gioco dell'impiccato</h3>
            </div>
        </div>

        <div class="center">
            <div class="hangman">
                <div class="hangman-drawing" data-errors="<?php echo intval($errors); ?>">
                    <div class="piece base"></div>
                    <div class="piece post"></div>
                    <div class="piece bar"></div>
                    <div class="piece rope"></div>
                    <div class="piece head"></div>
                    <div class="piece torso"></div>
                    <div class="piece arm-l"></div>
                    <div class="piece arm-r"></div>
                    <div class="piece leg-l"></div>
                    <div class="piece leg-r"></div>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <div class="word" id="display-word"><?php echo htmlspecialchars($displayWord); ?></div>

                <?php if ($gameOver): ?>
                    <?php if ($win): ?>
                        <div class="alert alert-success">Hai vinto! Parola: <?php echo htmlspecialchars($secretWord); ?></div>
                    <?php else: ?>
                        <div class="alert alert-danger">Hai perso. Parola: <?php echo htmlspecialchars($secretWord); ?></div>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="post" action="" class="mb-2">
                    <div class="input-group" style="max-width:240px;">
                        <input
                            type="text" 
                            name="letter" 
                            maxlength="1" 
                            class="form-control" 
                            placeholder="Inserisci lettera" 
                            autocomplete="off"
                            pattern="[A-Za-z]"
                            required
                            autofocus
                        >
                        <button class="btn btn-secondary" type="submit">Invia</button>
                    </div>
                </form>

                <p><strong>Tentativi rimasti:</strong> <span id="attempts-left"><?php echo intval($_SESSION['attemptsLeft']); ?></span></p>
                <p><strong>Lettere provate:</strong> <span id="guessed-letters"><?php echo htmlspecialchars(implode(', ', $guessedLetters)); ?></span></p>

                <div class="mt-2">
                    <form method="post" action="" style="display:inline-block;">
                        <button type="submit" name="new_game" class="btn btn-primary">Ritenta</button>
                    </form>
                    <form method="post" action="" style="display:inline-block; margin-left:8px;">
                        <button type="submit" name="select_level" class="btn btn-secondary">Seleziona livello</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>