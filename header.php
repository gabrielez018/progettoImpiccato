<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <?php
            if ($authorized) {
            ?>
                <a class="nav-link" href="logout.php">Logout (<?php echo htmlspecialchars($current_user); ?>)</a>
        </li>
    <?php } else { ?>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
        </li>
    <?php } ?>
    </ul>
</nav>
</div>