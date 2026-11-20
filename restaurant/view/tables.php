<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/css/styles.css?v=6">
</head>
<body class="page">
    <div class="brand brand-app">
        <span class="brand-mark">R</span>
        <span class="brand-name">Restaurant POS</span>
    </div>

    <?php if ($welcome): ?>
        <p class="note note-success note-page" role="status">Welcome back</p>
    <?php endif; ?>

    <?php if ($paid !== null): ?>
        <p class="note note-success note-page" role="status">
            <?= (float) $paid > 0 ? 'Payment registered · $' . $paid . ' · table free again' : 'Table closed' ?>
        </p>
    <?php endif; ?>

    <main class="panel panel-table">
        <div class="panel-head">
            <div>
                <h1>Tables</h1>
                <p class="subtitle"><?= $availableCount ?> available · <?= $occupiedCount ?> occupied</p>
            </div>

            <div class="actions">
                <a href="users.php" class="btn-ghost btn-sm">Users</a>
                <form method="POST" action="logout.php">
                    <button type="submit" class="btn-ghost btn-sm">Logout</button>
                </form>
            </div>
        </div>

        <div class="table-grid">
            <?php foreach ($tables as $table): ?>
                <?php $isOccupied = $table['status'] === 'occupied'; ?>

                <div class="table-card <?= $isOccupied ? 'occupied' : '' ?>">
                    <div>
                        <div class="table-number">Table <?= (int) $table['number'] ?></div>
                        <div class="table-status"><?= $isOccupied ? 'Occupied' : 'Available' ?></div>
                    </div>

                    <form method="GET" action="order.php">
                        <input type="hidden" name="id" value="<?= (int) $table['id_table'] ?>">
                        <button type="submit" class="btn-block btn-sm <?= $isOccupied ? 'btn-ghost' : 'btn-accent' ?>">
                            <?= $isOccupied ? 'View order' : 'Open order' ?>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
