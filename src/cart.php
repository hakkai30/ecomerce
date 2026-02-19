<?php
session_start();
require_once 'inc/config.php';
require_once 'inc/functions.php';

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $product_id = (int)$_POST['product_id'];
        removeFromCart($product_id);
    } elseif (isset($_POST['update_quantity'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        updateCartQuantity($product_id, $quantity);
    }
    header('Location: cart.php');
    exit;
}

$page_title = 'Carret de la compra';
require_once 'inc/header.php';
?>

<main class="main-content">
    <h2>Carret de la compra</h2>

    <?php 
    $cart_items = getCartItems();
    if (empty($cart_items)): ?>
        <p class="empty-cart">El vostre carret està buit. <a href="index.php">Tornar a la botiga</a></p>
    <?php else: ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Producte</th>
                    <th>Preu unitari</th>
                    <th>Quantitat</th>
                    <th>Subtotal</th>
                    <th>Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nom']); ?></td>
                        <td><?php echo formatPrice($item['preu']); ?></td>
                        <td>
                            <form method="post" class="quantity-form">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="update_quantity" value="1">
                                <input type="number" name="quantity" value="<?php echo $item['quantitat']; ?>" 
                                       min="1" class="quantity-input">
                                <button type="submit" class="btn btn-small">Actualitzar</button>
                            </form>
                        </td>
                        <td><?php echo formatPrice($item['subtotal']); ?></td>
                        <td>
                            <form method="post" class="remove-form" onsubmit="return confirm('Segur que voleu eliminar aquest producte?');">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="remove" value="1">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal (sense IVA):</span>
                <strong><?php echo formatPrice(getCartSubtotal()); ?></strong>
            </div>
            <div class="summary-row">
                <span>IVA (21%):</span>
                <strong><?php echo formatPrice(getCartSubtotal() * IVA); ?></strong>
            </div>
            <div class="summary-row total">
                <span>Total final:</span>
                <strong><?php echo formatPrice(getCartTotal()); ?></strong>
            </div>
        </div>

        <div class="cart-actions">
            <a href="index.php" class="btn btn-secondary">Continuar comprant</a>
        </div>

    <?php endif; ?>
</main>

<?php require_once 'inc/footer.php'; ?>
