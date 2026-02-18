<?php
require_once('authorization.php');

if (!isset($authorized) || $authorized !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gioco dell'impiccato - Selezione Livello</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>

    <?php require_once 'header.php'; ?>

    <div class="container py-5">
        
        <div class="top text-center mb-4">
            <h1 class="display-4 text-uppercase">Gioco dell'impiccato</h1>
            <h2 class="h4 text-muted">Seleziona il livello di difficoltà</h2>
        </div>

        <div class="center d-flex justify-content-center">
            <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%;">
                
                <form action="game.php" method="POST">
                    <?php
                    require_once('tools.php');
                    $levels = getLevels();

                    if (!empty($levels)) {
                        echo "<div class='list-group mb-4'>";

                        foreach ($levels as $index => $livello) {
                            echo "
                            <label class='list-group-item' for='lvl_$index'>
                                <input class='form-check-input me-3' type='radio' name='level' id='lvl_$index' value='$livello' required>
                                <span>Livello <b>$livello</b> </span>
                            </label>";
                        }

                        echo "</div>";
                        
                        echo "
                            <div class='text-center'>
                                <button type='submit' class='btn btn-primary btn-lg w-100'>
                                    Inizia a giocare
                                </button>
                            </div>
                        ";
                    } else {
                        echo "<div class='alert alert-warning text-center'>Nessun livello disponibile.</div>";
                    }
                    ?>
                </form>

            </div>
        </div>
    </div>

</body>

</html>