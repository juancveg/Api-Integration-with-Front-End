<?php
/**
 * index.php — Home page: shows a random featured product from the Fake Store API.
 */

$products = json_decode(file_get_contents('https://fakestoreapi.com/products'), true);

if (!$products) {
    die('Could not load products. Please try again later.');
}

$product = $products[array_rand($products)];
$year    = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store — Featured Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #f7f7f7; font-family: 'Montserrat', sans-serif; color: #333; }
        .navbar { background: #fff; border-bottom: 1px solid #e0e0e0; }
        .navbar-brand { font-weight: 700; font-size: 1.6rem; color: #333 !important; }
        .section-title { font-size: 1.8rem; font-weight: 700; }
        .section-sub   { font-size: 1rem; color: #777; }
        .card          { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .card-img-top  { height: 260px; object-fit: contain; background: #fafafa; padding: 20px; }
        .badge-category {
            display: inline-block; background: #f0f0f0; color: #555;
            border-radius: 20px; padding: 4px 12px; font-size: .75rem; margin-bottom: 10px;
        }
        .rating { color: #f5a623; font-size: .9rem; }
        .btn-dark  { border-radius: 20px; padding: 10px 28px; }
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

<div class="container text-center" style="margin-top: 110px;">
    <h1 class="section-title">Featured Product of the Day</h1>
    <p class="section-sub mb-5">Hand-picked just for you.</p>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <img src="<?= htmlspecialchars($product['image']) ?>"
                     class="card-img-top"
                     alt="<?= htmlspecialchars($product['title']) ?>">
                <div class="card-body text-left p-4">
                    <span class="badge-category"><?= htmlspecialchars($product['category']) ?></span>
                    <h5 class="card-title font-weight-600 mb-2"><?= htmlspecialchars($product['title']) ?></h5>
                    <div class="rating mb-2">
                        ★ <?= $product['rating']['rate'] ?> <span class="text-muted">(<?= $product['rating']['count'] ?> reviews)</span>
                    </div>
                    <p class="h5 font-weight-bold mb-3">$<?= number_format($product['price'], 2) ?></p>
                    <a href="detalle.php?id=<?= $product['id'] ?>" class="btn btn-dark btn-block">View Details</a>
                </div>
            </div>
            <div class="mt-3">
                <a href="listado.php" class="btn btn-outline-secondary">Browse All Products</a>
            </div>
        </div>
    </div>
</div>

<div class="footer">&copy; <?= $year ?> Online Store. All rights reserved.</div>

</body>
</html>
