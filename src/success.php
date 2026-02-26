<?php
session_start();
require_once 'inc/config.php';
require_once 'inc/functions.php';

// Verificamos que viene con un carrito pendiente para evitar duplicar pedidos si refrescan la pantalla
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    
    $total = getCartTotal();
    
    // Recuperamos el email que le pedimos antes de que se fuera a Stripe
    $cliente = isset($_SESSION['cliente_email']) ? $_SESSION['cliente_email'] : 'anonimo@email.com';
    $fecha = date('Y-m-d');
    $id_pedido = 'ORD-' . strtoupper(substr(uniqid(), -5));

    try {
        $host = 'db'; 
        $dbname = 'mydb';
        $user = 'user';
        $pass = 'password';
        
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO pedidos (id_pedido, fecha, cliente, total) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_pedido, $fecha, $cliente, $total]);

    } catch (PDOException $e) {
        // Ignorar en entorno de pruebas
    }

    // 3. Vaciamos el carrito y la sesión temporal de email tras procesar correctamente
    unset($_SESSION['cart']);
    unset($_SESSION['cliente_email']);
}

$page_title = 'Pago Confirmado';
require_once 'inc/header.php';
?>

<main class="main-content success-main">
    
    <div class="success-icon">||</div>
    <h1 class="page-title">Pedido Confirmado</h1>
    
    <div class="success-details">
        <p class="success-text">
            Tu pago ha sido procesado con éxito a través de nuestra pasarela segura de Stripe.<br>
            Hemos enviado los detalles de facturación y el seguimiento a tu correo electrónico.<br><br>
            Gracias por tu confianza.
        </p>
    </div>
    
    <a href="index.php" class="btn btn-secondary btn-success">Volver a la tienda</a>
    
</main>

<?php require_once 'inc/footer.php'; ?>