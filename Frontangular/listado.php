<?php
/**
 * listado.php — Full product listing table from the Fake Store API.
 */

$products = json_decode(file_get_contents('https://fakestoreapi.com/products'), true);

if (!$products) {
    die('Could not load products. Please try again later.');
}

$year = date('Y');

// Collect unique categories for the filter
$categories = array_unique(array_column($products, 'category'));
sort($categories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store — Product Listing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #f7f7f7; font-family: 'Montserrat', sans-serif; color: #333; }
        .navbar { background: #fff; border-bottom: 1px solid #e0e0e0; }
        .navbar-brand { font-weight: 700; font-size: 1.6rem; color: #333 !important; }
        .section-title { font-size: 1.8rem; font-weight: 700; }
        .table-responsive { box-shadow: 0 2px 8px rgba(0,0,0,.1); border-radius: 10px; overflow: hidden; }
        .table thead th { background: #333; color: #fff; border: none; vertical-align: middle; text-align: center; }
        .table tbody td { vertical-align: middle; text-align: center; font-size: .9rem; }
        .table tbody tr:hover { background: #f1f1f1; }
        .badge-category { background: #f0f0f0; color: #555; border-radius: 20px; padding: 3px 10px; font-size: .75rem; }
        .btn-sm { border-radius: 20px; }
        .footer { margin-top: 60px; padding: 20px 0; background: #fff; border-top: 1px solid #e0e0e0; text-align: center; color: #777; font-size: .85rem; }

        /* Category filter buttons */
        .filter-btn { border-radius: 20px; margin: 3px; font-size: .8rem; }
        .filter-btn.active { background: #333; color: #fff; border-color: #333; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand mx-auto" href="index.php">ONLINE STORE</a>
    </div>
</nav>

<div class="container" style="margin-top: 100px;">
    <h1 class="section-title text-center">Product Listing</h1>
    <p class="text-center text-muted mb-3">Browse our full catalogue.</p>

    <!-- Category filter -->
    <div class="text-center mb-4">
        <button class="btn btn-outline-dark btn-sm filter-btn active" data-category="all">All</button>
        <?php foreach ($categories as $cat): ?>
            <button class="btn btn-outline-dark btn-sm filter-btn" data-category="<?= htmlspecialchars($cat) ?>">
                <?= htmlspecialchars(ucfirst($cat)) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="productsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Rating</th>
                    <th>Reviews</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr data-category="<?= htmlspecialchars($p['category']) ?>">
                    <td><?= $p['id'] ?></td>
                    <td class="text-left"><?= htmlspecialchars($p['title']) ?></td>
                    <td>$<?= number_format($p['price'], 2) ?></td>
                    <td><span class="badge-category"><?= htmlspecialchars($p['category']) ?></span></td>
                    <td>★ <?= $p['rating']['rate'] ?? 'N/A' ?></td>
                    <td><?= $p['rating']['count'] ?? 'N/A' ?></td>
                    <td>
                        <a href="detalle.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm">Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary" style="border-radius:20px;padding:10px 28px;">← Home</a>
    </div>
</div>

<div class="footer">&copy; <?= $year ?> Online Store. All rights reserved.</div>

<script>
// Client-side category filter
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const category = this.dataset.category;
        document.querySelectorAll('#productsTable tbody tr').forEach(row => {
            row.style.display = (category === 'all' || row.dataset.category === category) ? '' : 'none';
        });
    });
});
</script>

</body>
</html>
