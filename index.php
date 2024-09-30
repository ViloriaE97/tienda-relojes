<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $query = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe
    if ($user) {
        // Verificar si la contraseña es correcta
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];
            // Redirigir a la página correspondiente
            header('Location: ' . ($user['rol'] === 'admin' ? 'admin/index.php' : 'client/index.php'));
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Relojes</title>
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
            <h2>Bienvenido</h2>
            <!-- Mostrar error específico -->
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="index.php">
                <div class="input-group">
                    <input type="text" name="username" required>
                    <label>Usuario</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label>Contraseña</label>
                </div>
                <button type="submit">Iniciar Sesión</button>
                <p class="note">Accede como <span>Usuario</span> o <span>Administrador</span></p>
            </form>
        </div>
    </div>
</body>
</html>
