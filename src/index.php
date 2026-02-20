<?php
session_start();
require_once 'inc/config.php';
require_once 'inc/functions.php';

// Procesar acciones del carrito (añadir producto)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
    addToCart($product_id, $quantity);
    header('Location: index.php?added=1');
    exit;
}

require_once 'inc/header.php';
?>

<main class="main-content">
    
    <?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
        <div class="alert alert-success">¡Producto añadido al carrito!</div>
    <?php endif; ?>

    <p class="product-count"><?php echo count(getProducts()); ?> Productos</p>

    <div class="product-grid">
        <?php foreach (getProducts() as $product): ?>
            <article class="product-card">
                <a href="#" class="product-image-link">
                    <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" class="product-image">
                </a>
                <div class="product-info">
                    <p class="product-code"><?php echo sprintf('P%03d', $product['id']); ?></p>
                    <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                    <p class="product-descripcio"><?php echo htmlspecialchars($product['descripcio']); ?></p>
                    <p class="product-brand">E-commerce</p>
                    <p class="price-block">
                        <span class="price-label">Precio regular</span>
                        <span class="price"><?php echo formatPrice($product['preu']); ?></span>
                    </p>
                    <form method="post" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="add_to_cart" value="1">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-quick-buy">Añadir al carrito</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once 'inc/footer.php'; ?>
