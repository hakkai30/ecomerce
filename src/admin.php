<?php
session_start();
$page_title = 'Dashboard Admin';
require_once 'inc/header.php';

// Configuración de la base de datos 
$host = 'db'; 
$dbname = 'mydb';
$user = 'user';
$pass = 'password';

$ventas_recientes = [];
$ventas_mes_actual = 0;
$error_db = null;

try {
    // Conexión PDO a MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Obtener informes de ventas (Requisito: Dashboard)
    $stmt = $pdo->query("SELECT id_pedido as id, fecha, cliente, total FROM pedidos ORDER BY fecha DESC LIMIT 10");
    $ventas_recientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Obtener el total de ventas para la predicción (Requisito: Eines de predicció)
    $stmtTotal = $pdo->query("SELECT SUM(total) as total_mes FROM pedidos");
    $resultadoTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
    $ventas_mes_actual = $resultadoTotal['total_mes'] ? (float)$resultadoTotal['total_mes'] : 0;

} catch(PDOException $e) {
    $error_db = "Error de conexión a la base de datos. Asegúrate de que el contenedor MySQL está en marcha.";
}

// Cálculo para la predicción
$crecimiento_estimado = 0.15; 
$prediccion_mes_siguiente = $ventas_mes_actual * (1 + $crecimiento_estimado);
?>

<main class="main-content">
    <h1 class="page-title" style="text-align: center; margin-bottom: 3rem;">Dashboard de Administración</h1>
    
    <?php if ($error_db): ?>
        <div class="alert alert-danger" style="color: #ff4d4d; border: 1px solid #ff4d4d; padding: 1rem; margin-bottom: 2rem;">
            <?php echo $error_db; ?>
        </div>
    <?php endif; ?>

    <section style="margin-bottom: 4rem;">
        <h2 style="font-size: 1.1rem; border-bottom: 1px solid var(--color-border); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Informes de Ventas Recientes</h2>
        <div class="cart-table-wrap">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($ventas_recientes)): ?>
                        <tr><td colspan="4" style="text-align:center;">No hay ventas registradas.</td></tr>
                    <?php else: ?>
                        <?php foreach($ventas_recientes as $venta): ?>
                        <tr>
                            <td style="font-family: var(--font-sans); font-size: 0.8rem;"><?php echo htmlspecialchars($venta['id']); ?></td>
                            <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($venta['cliente']); ?></td>
                            <td><?php echo number_format($venta['total'], 2, ',', '.'); ?> €</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <h2 style="font-size: 1.1rem; border-bottom: 1px solid var(--color-border); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Herramientas de Predicción de Ventas</h2>
        
        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            
            <div style="flex: 1; min-width: 250px; padding: 2rem; background: var(--color-surface); border: 1px solid var(--color-border); text-align: center;">
                <h3 style="color: var(--color-text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: var(--letter-spacing);">Ventas Mes Actual</h3>
                <p style="font-size: 2rem; font-family: var(--font-serif); margin: 1rem 0;"><?php echo number_format($ventas_mes_actual, 2, ',', '.'); ?> €</p>
            </div>
            
            <div style="flex: 1; min-width: 250px; padding: 2rem; background: var(--color-surface); border: 1px solid var(--color-border); text-align: center; position: relative; overflow: hidden;">
                <h3 style="color: var(--color-text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: var(--letter-spacing);">Predicción Próximo Mes (+15%)</h3>
                <p style="font-size: 2rem; font-family: var(--font-serif); margin: 1rem 0; color: #a3cfa3;"><?php echo number_format($prediccion_mes_siguiente, 2, ',', '.'); ?> €</p>
            </div>
            
        </div>
        
        <p style="margin-top: 1.5rem; color: var(--color-text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
            * Predicción calculada matemáticamente usando los datos de la base de datos local.
        </p>
    </section>
</main>

<?php require_once 'inc/footer.php'; ?>