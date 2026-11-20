<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted user</title>
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
            <h1>User deleted</h1>
            <p class="subtitle">This user was removed from the database</p>
        </div>

        <dl class="details">
            <div>
                <dt>ID</dt>
                <dd><?= (int) $user['id_user'] ?></dd>
            </div>
            <div>
                <dt>Name</dt>
                <dd><?= htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
            <div>
                <dt>Last name</dt>
                <dd><?= htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
            <div>
                <dt>Email</dt>
                <dd><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></dd>
            </div>
        </dl>

        <a href="users.php" class="btn-accent btn-block">Back to users</a>
    </main>
</body>
</html>

