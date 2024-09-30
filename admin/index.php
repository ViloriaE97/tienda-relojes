<?php
include '../includes/db.php';

/*session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}*/

$query = $conn->query("SELECT * FROM relojes");
$relojes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Admin - Relojes</title>
    <link rel="stylesheet" href="../assets/css/styles_admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h1>Lista de Relojes</h1>
        <a id="add" href="add.php">Agregar</a>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Marca</th>
                    <th>Características</th>
                    <th>Precio</th>
                    <th>Foto</th>
                    <th>Vendidos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($relojes as $reloj): ?>
                <tr>
                    <td><?= $reloj['codigo'] ?></td>
                    <td><?= $reloj['marca'] ?></td>
                    <td><?= $reloj['caracteristicas'] ?></td>
                    <td><?= $reloj['precio'] ?></td>
                    <td><img src="../uploads/<?= $reloj['foto'] ?>" alt="<?= $reloj['marca'] ?>" width="80"></td>
                    <td><?= $reloj['vendidos'] ?></td>
                    <td>
                        <a id="edit" href="edit.php?id=<?= $reloj['id'] ?>">Editar</a> |
                        <a id="delete" href="delete.php?id=<?= $reloj['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este reloj?');">Eliminar</a>
                    </td>
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
