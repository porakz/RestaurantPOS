<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table <?= (int) $table['number'] ?> · Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/css/styles.css?v=6">
</head>
<body class="page">
    <div class="brand brand-app">
        <span class="brand-mark">R</span>
        <span class="brand-name">Restaurant POS</span>
    </div>

    <main class="order-layout">
        <aside class="panel order-side">
            <div class="order-side-head">
                <h1>Table <?= (int) $table['number'] ?></h1>
                <span class="order-status">Occupied</span>
            </div>

            <div class="order-meta">
                <div>Waiter <b><?= htmlspecialchars(trim(($waiter['first_name'] ?? '') . ' ' . ($waiter['last_name'] ?? '')) ?: 'Unknown', ENT_QUOTES, 'UTF-8') ?></b></div>
                <div>Opened <b><?= $table['opened_at'] !== null ? date('g:i A', strtotime($table['opened_at'])) : '—' ?></b></div>
            </div>

            <div class="order-items">
                <?php if (!$orderLines): ?>
                    <p class="order-empty">No items yet. Add something from the menu</p>
                <?php endif; ?>

                <?php foreach ($orderLines as $orderLine): ?>
                    <div class="order-line">
                        <div>
                            <div class="order-line-name"><?= htmlspecialchars($orderLine['item_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="order-line-meta">$<?= number_format((float) $orderLine['item_price'], 2) ?> each</div>
                        </div>

                        <div class="order-line-actions">
                            <form method="POST" action="order.php">
                                <input type="hidden" name="id" value="<?= (int) $table['id_table'] ?>">
                                <input type="hidden" name="action" value="less">
                                <input type="hidden" name="line" value="<?= (int) $orderLine['id_order_item'] ?>">
                                <button type="submit" class="btn-ghost btn-xs" aria-label="Remove one">−</button>
                            </form>

                            <span class="order-qty"><?= (int) $orderLine['quantity'] ?></span>

                            <form method="POST" action="order.php">
                                <input type="hidden" name="id" value="<?= (int) $table['id_table'] ?>">
                                <input type="hidden" name="action" value="more">
                                <input type="hidden" name="line" value="<?= (int) $orderLine['id_order_item'] ?>">
                                <button type="submit" class="btn-ghost btn-xs" aria-label="Add one">+</button>
                            </form>

                            <form method="POST" action="order.php">
                                <input type="hidden" name="id" value="<?= (int) $table['id_table'] ?>">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="line" value="<?= (int) $orderLine['id_order_item'] ?>">
                                <button type="submit" class="btn-danger btn-xs" aria-label="Remove line">×</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="order-total">
                <span>Total</span>
                <span>$<?= number_format($total, 2) ?></span>
            </div>

            <div class="order-foot">
                <form method="POST" action="order.php" onsubmit="return confirm('<?= $orderLines ? 'Charge $' . number_format($total, 2) . ' and close table ' . (int) $table['number'] . '?' : 'Table ' . (int) $table['number'] . ' has no items. Close it anyway?' ?>');">
                    <input type="hidden" name="id" value="<?= (int) $table['id_table'] ?>">
                    <input type="hidden" name="action" value="pay">
                    <button type="submit" class="btn-accent btn-block">
                        <?= $orderLines ? 'Pay $' . number_format($total, 2) : 'Close table' ?>
                    </button>
                </form>

                <a href="tables.php" class="btn-ghost btn-block">Back to tables</a>
            </div>
        </aside>

        <section class="panel order-menu">
            <div class="panel-head">
                <div>
                    <h2>Menu</h2>
                    <p class="subtitle">Tap an item to add it to the table</p>
                </div>
            </div>

            <?php foreach ($menuByCategory as $categoryName => $categoryMenuItems): ?>
                <div class="order-cat">
                    <h3><?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?></h3>

                    <div class="menu-grid">
                        <?php foreach ($categoryMenuItems as $menuItem): ?>
                            <form method="POST" action="order.php">
                                <input type="hidden" name="id" value="<?= (int) $table['id_table'] ?>">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="id_item" value="<?= (int) $menuItem['id_item'] ?>">
                                <button type="submit" class="menu-btn">
                                    <span><?= htmlspecialchars($menuItem['item_name'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <span class="menu-price">$<?= number_format((float) $menuItem['item_price'], 2) ?></span>
                                </button>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
