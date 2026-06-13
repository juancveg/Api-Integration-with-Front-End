<?php
/**
 * detalle.php — Full detail view for a single product.
 */

if (!isset($_GET['id'])) {
    header('Location: listado.php');
    exit();
}

$id = intval($_GET['id']);

if ($id <= 0) {
    header('Location: listado.php');
    exit();
}

$product = json_decode(file_get_contents("https://fakestoreapi.com/products/$id"), true);

if (!$product) {
    die('Product not found.');
}

// Star rating helper
function renderStars(float $rate): string {
    $full  = floor($rate);
    $half  = ($rate - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    return str_repeat('★', $full) . str_repeat('½', $half) . str_repeat('☆', $empty);
}

$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['title']) ?> — Online Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #f7f7f7; font-family: 'Montserrat', sans-serif; color: #333; }
        .navbar { background: #fff; border-bottom: 1px solid #e0e0e0; }
        .navbar-brand { font-weight: 700; font-size: 1.6rem; color: #333 !important; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .product-img { height: 320px; object-fit: contain; background: #fafafa; padding: 24px; border-radius: 12px 0 0 12px; }
        .badge-category { background: #f0f0f0; color: #555; border-radius: 20px; padding: 4px 14px; font-size: .8rem; }
        .rating-stars { color: #f5a623; font-size: 1.1rem; letter-spacing: 2px; }
        .price { font-size: 2rem; font-weight: 700; }
        .btn-dark { border-radius: 20px; padding: 12px 32px; }
        .btn-outline-secondary { border-radius: 20px; padding: 10px 28px; }
        .footer { margin-top: 60px; padding: 20px 0; background: #fff; border-top: 1px solid #e0e0e0; text-align: center; color: #777; font-size: .85rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand mx-auto" href="index.php">ONLINE STORE</a>
    </div>
</nav>

<div class="container" style="margin-top: 110px;">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background:transparent;padding:0;">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="listado.php">Products</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($product['title']) ?></li>
        </ol>
    </nav>

    <div class="card mb-4" style="max-width: 860px; margin: 0 auto;">
        <div class="row no-gutters">
            <div class="col-md-4 d-flex align-items-center justify-content-center p-3">
                <img src="<?= htmlspecialchars($product['image']) ?>"
                     class="product-img w-100"
                     alt="<?= htmlspecialchars($product['title']) ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body p-4">
                    <span class="badge-category"><?= htmlspecialchars(ucfirst($product['category'])) ?></span>
                    <h4 class="mt-2 mb-1 font-weight-600"><?= htmlspecialchars($product['title']) ?></h4>

                    <div class="my-2">
                        <span class="rating-stars"><?= renderStars((float)($product['rating']['rate'] ?? 0)) ?></span>
                        <span class="text-muted ml-1" style="font-size:.9rem;">
                            <?= $product['rating']['rate'] ?? 'N/A' ?> / 5
                            (<?= $product['rating']['count'] ?? 0 ?> reviews)
                        </span>
                    </div>

                    <p class="price my-3">$<?= number_format($product['price'], 2) ?></p>

                    <p class="text-muted" style="font-size:.95rem;line-height:1.6;">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>

                    <div class="mt-4 d-flex flex-wrap" style="gap:10px;">
                        <button class="btn btn-dark" onclick="alert('Feature coming soon!')">Add to Cart</button>
                        <a href="listado.php" class="btn btn-outline-secondary">← Back to Listing</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">&copy; <?= $year ?> Online Store. All rights reserved.</div>

</body>
</html>
