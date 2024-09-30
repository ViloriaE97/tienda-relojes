<?php
session_start();
include '../includes/db.php';

/*
// Verifica si el usuario está autenticado como administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
*/

// Obtener datos estadísticos
$totalRelojes = $conn->query("SELECT COUNT(*) FROM relojes")->fetchColumn();
$relojesPorMarca = $conn->query("SELECT marca, COUNT(*) as cantidad FROM relojes GROUP BY marca")->fetchAll(PDO::FETCH_ASSOC);
$masCaro = $conn->query("SELECT * FROM relojes ORDER BY precio DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$masBarato = $conn->query("SELECT * FROM relojes ORDER BY precio ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$masVendido = $conn->query("SELECT * FROM relojes ORDER BY RAND() LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$masStockMarca = $conn->query("SELECT marca, COUNT(*) as cantidad FROM relojes GROUP BY marca ORDER BY cantidad DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$menosStockMarca = $conn->query("SELECT marca, COUNT(*) as cantidad FROM relojes GROUP BY marca ORDER BY cantidad ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Admin</title>
    <link rel="stylesheet" href="../assets/css/styles_dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="sidebar">
        <h2>Menú Admin</h2>
        <ul>
            <li><a href="index.php">Lista de Relojes</a></li>
            <li><a href="add.php">Agregar Nuevo Reloj</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="../client/index.php">Portal Usuarios</a></li>
            <li><a href="../logout.php">Cerrar Sesión</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Dashboard de Admin</h1>
        <div class="stats-container">
            <div class="stat-box">
                <h2>Total de Relojes</h2>
                <p><?= $totalRelojes ?></p>
            </div>
            <div class="stat-box">
                <h2>Reloj Más Caro</h2>
                <p><?= $masCaro['marca'] ?> - $<?= $masCaro['precio'] ?></p>
            </div>
            <div class="stat-box">
                <h2>Reloj Más Barato</h2>
                <p><?= $masBarato['marca'] ?> - $<?= $masBarato['precio'] ?></p>
            </div>
            <div class="stat-box">
                <h2>Reloj Más Vendido</h2>
                <p><?= $masVendido['marca'] ?> - $<?= $masVendido['precio'] ?></p>
            </div>
            <div class="stat-box">
                <h2>Marca con Más Stock</h2>
                <p><?= $masStockMarca['marca'] ?> - <?= $masStockMarca['cantidad'] ?> unidades</p>
            </div>
            <div class="stat-box">
                <h2>Marca con Menos Stock</h2>
                <p><?= $menosStockMarca['marca'] ?> - <?= $menosStockMarca['cantidad'] ?> unidades</p>
            </div>
        </div>

        <h2>Relojes por Marca</h2>
        <table>
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($relojesPorMarca as $marca): ?>
                    <tr>
                        <td><?= $marca['marca'] ?></td>
                        <td><?= $marca['cantidad'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        const sidebar = document.querySelector('.sidebar');
        const toggleButton = document.querySelector('.toggle-btn');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
</body>
</html>
