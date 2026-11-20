<?php
$error = $_GET['error'] ?? '';
$databaseError = isset($_GET['database']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <h1>Create account</h1>
            <p class="subtitle">It only takes a minute</p>
        </div>

        <?php if ($error !== ''): ?>
            <p class="note note-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php elseif ($databaseError): ?>
            <p class="note note-error" role="alert">Database error</p>
        <?php endif; ?>

        <form method="POST" action="../controller/register.php" class="stack">
            <div>
                <label for="first_name">First name</label>
                <input type="text" id="first_name" name="first_name" autocomplete="given-name" required>
            </div>
            <div>
                <label for="last_name">Last name</label>
                <input type="text" id="last_name" name="last_name" autocomplete="family-name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" autocomplete="email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" minlength="3" required>
            </div>
            <div>
                <label for="confirm_password">Confirm password</label>
                <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" minlength="3" required>
            </div>
            <button type="submit" class="btn-accent btn-block">Register</button>
        </form>

        <a href="index.php" class="btn-ghost btn-block auth-alt">Back to login</a>
    </main>
</body>
</html>

