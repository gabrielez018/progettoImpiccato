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

    <div class="top text-center mb-4">
            <h1 class="display-4 text-uppercase">
                Gioco dell'impiccato
            </h1>

            <span class="badge bg-light text-dark border mb-2">
                Difficoltà: <strong><?php echo htmlspecialchars($levelName); ?></strong>
            </span>
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
                
                <?php if ($gameOver): ?>
                    <div class="alert alert-<?php echo $win ? 'success' : 'danger'; ?> mb-4">
                        <?php echo $win ? 'Hai vinto!' : 'Hai perso.'; ?> 
                        Parola: <strong><?php echo htmlspecialchars($secretWord); ?></strong>
                    </div>
                <?php endif; ?>

                <div class="row align-items-center">
                    
                    <div class="col-md-auto pe-md-5">
                        <form method="post" action="" class="mb-3">
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
                                    oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')"
                                    autofocus
                                >
                                <button class="btn btn-secondary" type="submit">Invia</button>
                            </div>
                        </form>

                        <p class="mb-1"><strong>Tentativi rimasti:</strong> <span id="attempts-left"><?php echo intval($_SESSION['attemptsLeft']); ?></span></p>
                        <p><strong>Lettere provate:</strong> <span id="guessed-letters"><?php echo htmlspecialchars(implode(', ', $guessedLetters)); ?></span></p>

                        <div class="mt-3">
                            <form method="post" action="" style="display:inline-block;">
                                <button type="submit" name="new_game" class="btn btn-primary">Ritenta</button>
                            </form>
                            <form method="post" action="" style="display:inline-block; margin-left:8px;">
                                <button type="submit" name="select_level" class="btn btn-secondary">Seleziona livello</button>
                            </form>
                        </div>
                    </div>

                    <div class="col text-center py-3">
                        <div class="word display-4" id="display-word"><?php echo htmlspecialchars($displayWord); ?></div>
                    </div>

                </div> </div>
        </div>
    </div>

</body>

</html>