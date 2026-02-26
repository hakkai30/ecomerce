<?php
session_start();
require_once 'inc/config.php';
require_once 'inc/functions.php';

$cart_items = getCartItems();
// Si el carrito está vacío, volvemos al inicio
if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}

$total = getCartTotal();

// Si el usuario ha introducido su email y pulsado "Pagar"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_email'])) {
    
    // Guardamos el email temporalmente en la sesión para usarlo luego en success.php
    $_SESSION['cliente_email'] = $_POST['cliente_email'];
    
    // Obtenemos la URL de tu tienda (por ejemplo http://localhost:8080)
    $domain_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    
    // 1. Preparamos los productos del carrito para que Stripe los entienda
    $line_items = [];
    foreach($cart_items as $item) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => $item['nom']],
                'unit_amount' => round($item['preu'] * 100), // Stripe pide el precio en céntimos
            ],
            'quantity' => $item['quantitat'],
        ];
    }
    
    // 2. Añadimos el IVA como un concepto separado para que cuadre el total
    $iva_amount = getCartSubtotal() * IVA;
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => ['name' => 'IVA (21%)'],
            'unit_amount' => round($iva_amount * 100),
        ],
        'quantity' => 1,
    ];

    // 3. Tu clave SECRETA de Stripe
    $stripe_secret = 'sk_test_51T56i8E74j6l6hC7H6sXRXYqxHGWKNgXRfJlPncAE6UJMLSHXmLm9E7TO9fWjeGshTNAl1T2DMC2rMTZdmHFKfJa004PwITyGd';
    
    // 4. Datos de la sesión de Stripe
    $data = [
        'success_url' => $domain_url . '/success.php', // A dónde vuelve si paga bien
        'cancel_url' => $domain_url . '/checkout.php', // A dónde vuelve si cancela
        'mode' => 'payment',
        'customer_email' => $_POST['cliente_email'],
        'line_items' => $line_items
    ];

    // 5. Comunicación directa por cURL con la API de Stripe
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/checkout/sessions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret . ':');
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    $json = json_decode($result, true);
    
    // 6. Si Stripe nos devuelve una URL válida, redirigimos allí
    if (isset($json['url'])) {
        header("Location: " . $json['url']);
        exit;
    } else {
        $error_api = "Error conectando con Stripe. Verifica tus claves.";
    }
}

$page_title = 'Pago Seguro';
require_once 'inc/header.php';
?>

<main class="main-content">
    <h1 class="page-title checkout-title">Finalizar Compra</h1>
    
    <div class="checkout-wrapper">
        <p class="checkout-total">
            Total a pagar <strong><?php echo formatPrice($total); ?></strong>
        </p>

        <?php if (isset($error_api)): ?>
            <div class="alert alert-danger" style="color:#ff4d4d;text-align:center;"><?php echo $error_api; ?></div>
        <?php endif; ?>
        
        <form action="checkout.php" method="post" id="payment-form">
            <div class="form-row">
                <label for="cliente_email">Correo electrónico para el recibo</label>
                <input type="email" name="cliente_email" id="cliente_email" class="form-input-text" placeholder="tu@email.com" required>
            </div>

            <div class="form-row" style="text-align: center; margin-top: 2rem;">
                <p style="font-size: 0.75rem; color: var(--color-text-muted);">
                    Serás redirigido a la pasarela oficial de Stripe para procesar el pago de forma totalmente segura.
                </p>
            </div>

            <button type="submit" class="btn btn-primary btn-checkout">
                Pagar con Stripe <?php echo formatPrice($total); ?>
            </button>
        </form>
    </div>
</main>

<?php require_once 'inc/footer.php'; ?>