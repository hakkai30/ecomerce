<?php
session_start();
require_once 'inc/config.php';
require_once 'inc/functions.php';

// Procesar acciones del carrito (afegir producte)
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
    <h2>Productes</h2>
    
    <?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
        <div class="alert alert-success">Producte afegit al carret!</div>
    <?php endif; ?>

    <div class="product-grid">
        <?php foreach (getProducts() as $product): ?>
            <article class="product-card">
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                    <p class="price"><?php echo formatPrice($product['preu']); ?></p>
                    
                    <form method="post" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="add_to_cart" value="1">
                        <label>
                            Quantitat:
                            <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                        </label>
                        <button type="submit" class="btn btn-primary">Afegir al carret</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once 'inc/footer.php'; ?>
