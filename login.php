<?php include('authorization.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<body>
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header bg-dark text-white">
						<h3>Login</h3>
					</div>
					<div class="card-body">
						<?php if (isset($_GET['error'])) { ?>
							<div class="alert alert-danger" role="alert">
								Credenziali non valide. Riprova.
							</div>
						<?php } ?>
						<form action="login-save.php" method="POST">
							<div class="mb-3">
								<label for="username" class="form-label">Username</label>
								<input type="text" class="form-control" id="username" name="username" required>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label">Password</label>
								<input type="password" class="form-control" id="password" name="password" required>
							</div>
							<button type="submit" class="btn btn-primary">Accedi</button>
							<a href="register.php" class="btn btn-primary">Registrati</a>
						</form>
						<hr>
						<p class="text-muted">Utenti di prova:</p>
						<ul>
							<li>admin / password123</li>
							<li>user / test</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>