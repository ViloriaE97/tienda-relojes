<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; // Nuevo campo para el nombre
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol']; // 'usuario' o 'admin'

    // Comprobar si el usuario ya existe
    $query = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $query->execute([$username]);

    if ($query->rowCount() > 0) {
        echo "<p>El nombre de usuario ya está en uso. Por favor, elige otro.</p>";
    } else {
        // Insertar en la base de datos
        $insertQuery = $conn->prepare("INSERT INTO usuarios (name, username, password, rol) VALUES (?, ?, ?, ?)");
        $insertQuery->execute([$name, $username, $password, $rol]);

        header('Location: login.php');
        exit; // Asegúrate de salir después de redirigir
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Relojes</title>
    <link rel="stylesheet" href="assets/css/styles_login.css">
</head>
<body>
    <div class="background-decorations">
        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="triangle"></div>
        <div class="square"></div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2>Registro</h2>
            <form method="POST" action="register.php">
                <div class="input-group">
                    <input type="text" name="name" required>
                    <label>Nombre Completo</label>
                </div>
                <div class="input-group">
                    <input type="text" name="username" required>
                    <label>Usuario</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label>Contraseña</label>
                </div>
                <div class="input-group">
                    <label for="rol">Rol:</label>
                    <select name="rol" required>
                        <option value="usuario">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>
