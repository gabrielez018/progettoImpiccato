<?php
declare(strict_types=1);

require_once __DIR__ . '/authorization.php';
require_once __DIR__ . '/tools.php';

// Enforce authentication: redirect to login if not authorized
if (!isset($authorized) || $authorized !== true) {
	header('Location: login.php');
	exit;
}

// Handle level selection (PRG pattern)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['start_game'])) {
	$level = $_POST['level'] ?? '';
	$_SESSION['level'] = $level;
	// populate session words for the selected level
	$_SESSION['words'] = getWord($level);
	// reset selected word so game will pick a new one
	unset($_SESSION['selectedWord']);
	header('Location: index.php');
	exit;
}

require_once __DIR__ . '/game.php';

$MAX_ATTEMPTS = 6;
$errors = max(0, $MAX_ATTEMPTS - intval($attemptsLeft));
// Friendly display name for current level
$levelName = isset($_SESSION['level']) ? $_SESSION['level'] : '';
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8" />
	<title>Gioco dell'impiccato</title>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link rel="stylesheet" href="hangman.css" />
	<style>
		.top { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
		.center { text-align:center; margin-bottom:12px; }
		.hangman { width:200px; height:200px; margin:0 auto 12px auto; display:flex; align-items:center; justify-content:center; }
		.word { font-size:28px; letter-spacing:4px; font-weight:600; text-align:center; margin-bottom:12px; }
		.levels { display:flex; flex-direction:column; gap:6px; }
	</style>
</head>
<body>
	<?php include __DIR__ . '/header.php'; ?>

	<div class="container mt-3">
		<?php if (!empty($_SESSION['game_error'])): ?>
			<div class="alert alert-danger"><?php echo htmlspecialchars((string)$_SESSION['game_error']); ?></div>
		<?php endif; ?>

		<?php if (empty($_SESSION['level']) || empty($_SESSION['selectedWord'])): ?>
			<div class="card p-3 mb-3">
				<h3>Seleziona livello</h3>
				<?php $levels = showLevel(); ?>
				<?php if (empty($levels)): ?>
					<div class="alert alert-warning">Nessun livello disponibile.</div>
				<?php else: ?>
					<form method="post" action="">
						<div class="mb-3">
							<?php foreach ($levels as $idx => $lv): ?>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="level" id="lvl<?php echo $idx; ?>" value="<?php echo htmlspecialchars($lv); ?>" <?php echo $idx === 0 ? 'checked' : ''; ?>>
									<label class="form-check-label" for="lvl<?php echo $idx; ?>"><?php echo htmlspecialchars($lv); ?></label>
								</div>
							<?php endforeach; ?>
						</div>
						<button type="submit" name="start_game" class="btn btn-primary">Inizia gioco</button>
					</form>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="top">
				<div><strong>Difficoltà:</strong> <?php echo htmlspecialchars($levelName); ?></div>
				<div class="text-center"><h3>Gioco dell'impiccato</h3></div>
				<div></div>
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
							<div class="alert alert-success">Hai vinto! Parola: <?php echo htmlspecialchars($selectedWord); ?></div>
						<?php else: ?>
							<div class="alert alert-danger">Hai perso. Parola: <?php echo htmlspecialchars($selectedWord); ?></div>
						<?php endif; ?>
					<?php endif; ?>

					<form method="post" action="" class="mb-2">
						<div class="input-group" style="max-width:240px;">
							<input type="text" name="letter" maxlength="1" class="form-control" placeholder="Inserisci lettera" autocomplete="off">
							<button class="btn btn-secondary" type="submit">Invia</button>
						</div>
					</form>

					<p><strong>Lettere provate:</strong> <span id="guessed-letters"><?php echo htmlspecialchars(implode(', ', $guessedLetters)); ?></span></p>
					<p><strong>Tentativi rimasti:</strong> <span id="attempts-left"><?php echo intval($attemptsLeft); ?></span></p>

					<div class="mt-2">
						<form method="post" action="" style="display:inline-block;">
							<button type="submit" name="new_game" class="btn btn-primary">Ritenta</button>
						</form>
					<form method="post" action="" style="display:inline-block; margin-left:8px;">
						<button type="submit" name="select_level" class="btn btn-secondary">Seleziona livello</button>
					</form>
						<a href="logout.php" class="btn btn-outline-secondary" style="margin-left:8px;">Logout</a>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</body>
</html>
