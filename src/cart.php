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

$page_title = 'Carrito de la compra';
require_once 'inc/header.php';
?>

<main class="main-content">
    <h1 class="page-title">Carrito de la compra</h1>

    <?php 
    $cart_items = getCartItems();
    if (empty($cart_items)): ?>
        <p class="empty-cart">Tu carrito está vacío. <a href="index.php">Volver a la tienda</a></p>
    <?php else: ?>

        <div class="cart-table-wrap">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td class="cart-product-cell">
                            <?php if (!empty($item['img'])): ?>
                                <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['nom']); ?>" class="cart-product-img">
                            <?php endif; ?>
                            <span class="cart-product-name"><?php echo htmlspecialchars($item['nom']); ?></span>
                        </td>
                        <td><?php echo formatPrice($item['preu']); ?></td>
                        <td>
                            <form method="post" class="quantity-form">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="update_quantity" value="1">
                                <input type="number" name="quantity" value="<?php echo $item['quantitat']; ?>" 
                                       min="1" class="quantity-input">
                                <button type="submit" class="btn btn-small">Actualizar</button>
                            </form>
                        </td>
                        <td><?php echo formatPrice($item['subtotal']); ?></td>
                        <td>
                            <form method="post" class="remove-form" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="remove" value="1">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal (sin IVA):</span>
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
