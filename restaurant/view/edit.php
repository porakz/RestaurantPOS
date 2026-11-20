<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
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
            <h1>Edit user</h1>
            <p class="subtitle">User #<?= (int) $user['id_user'] ?></p>
        </div>

        <?php if ($error !== ''): ?>
            <p class="note note-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="POST" action="edit.php" class="stack">
            <input type="hidden" name="id" value="<?= (int) $user['id_user'] ?>">

            <div>
                <label for="first_name">First name</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div>
                <label for="last_name">Last name</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current" autocomplete="new-password">
            </div>

            <button type="submit" class="btn-accent btn-block">Save changes</button>
        </form>

        <a href="users.php" class="btn-ghost btn-block auth-alt">Cancel</a>
    </main>
</body>
</html>

