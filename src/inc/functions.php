<?php
function addToCart($product_id, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $products = getProducts();
    if (isset($products[$product_id])) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}

function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function updateCartQuantity($product_id, $quantity) {
    if ($quantity <= 0) {
        removeFromCart($product_id);
    } elseif (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = (int)$quantity;
    }
}

function getCartItems() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }
    
    $products = getProducts();
    $items = [];
    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        if (isset($products[$product_id])) {
            $product = $products[$product_id];
            $items[] = [
                'id' => $product['id'],
                'nom' => $product['nom'],
                'preu' => $product['preu'],
                'img' => $product['img'] ?? '',
                'quantitat' => $quantity,
                'subtotal' => $product['preu'] * $quantity,
            ];
        }
    }
    
    return $items;
}

function getCartSubtotal() {
    $items = getCartItems();
    return array_sum(array_column($items, 'subtotal'));
}

function getCartTotal() {
    $subtotal = getCartSubtotal();
    return $subtotal * (1 + IVA);
}

function formatPrice($price) {
    return number_format($price, 2, ',', '.') . ' €';
}
