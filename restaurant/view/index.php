<?php
$registered = isset($_GET['registered']);
$loginError = isset($_GET['error']);
$databaseError = isset($_GET['database']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/css/styles.css?v=6">
</head>
<body class="page-center">
    <main class="panel panel-form">
        <div class="brand brand-center">
            <span class="brand-mark">R</span>
            <span class="brand-name">Restaurant POS</span>
        </div>

        <div class="title-block">
            <h1>Welcome</h1>
            <p class="subtitle">Sign in to continue</p>
        </div>

        <?php if ($registered): ?>
            <p class="note note-success" role="status">Account created</p>
        <?php elseif ($loginError): ?>
            <p class="note note-error" role="alert">Email or password incorrect</p>
        <?php elseif ($databaseError): ?>
            <p class="note note-error" role="alert">Database error</p>
        <?php endif; ?>

        <form method="POST" action="../controller/login.php" class="stack">
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="example@utrivieramaya.edu.mx" autocomplete="email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="********" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn-accent btn-block">Login</button>
        </form>

        <a href="register.php" class="btn-ghost btn-block auth-alt">Register</a>
    </main>
</body>
</html>

