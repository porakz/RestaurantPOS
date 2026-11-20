<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/css/styles.css?v=6">
</head>
<body class="page">
    <div class="brand brand-app">
        <span class="brand-mark">R</span>
        <span class="brand-name">Restaurant POS</span>
    </div>

    <?php if ($accountCreated): ?>
        <p class="note note-success note-page" role="status">Account created</p>
    <?php endif; ?>

    <main class="panel panel-table">
        <div class="panel-head">
            <div>
                <h1>Users</h1>
                <p class="subtitle">Total <?= User::countAll() ?> users</p>
            </div>

            <div class="actions">
                <a href="tables.php" class="btn-ghost btn-sm">Tables</a>
                <a href="../view/register.php" class="btn-accent btn-sm">Add user</a>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$users): ?>
                        <tr>
                            <td colspan="5" class="empty">No users yet</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= (int) $user['id_user'] ?></td>
                            <td><?= htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="edit.php?id=<?= (int) $user['id_user'] ?>" class="btn-accent btn-sm">Update</a>
                                    <form method="POST" action="delete.php" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="id" value="<?= (int) $user['id_user'] ?>">
                                        <button type="submit" class="btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="panel-foot">
            <form method="POST" action="logout.php">
                <button type="submit" class="btn-ghost">Logout</button>
            </form>
        </div>
    </main>
</body>
</html>

