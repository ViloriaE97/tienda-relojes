<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $marca = $_POST['marca'];
    $caracteristicas = $_POST['caracteristicas'];
    $precio = $_POST['precio'];
    
    // Verificar si el código ya existe en la base de datos
    $checkQuery = $conn->prepare("SELECT COUNT(*) FROM relojes WHERE codigo = ?");
    $checkQuery->execute([$codigo]);
    $exists = $checkQuery->fetchColumn();

    if ($exists > 0) {
        // Si el código ya existe, mostrar un mensaje de error
        echo "<script>alert('Error: Ya existe un reloj con este código.');</script>";
    } else {
        // Manejo de imagen
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = '../uploads/' . $foto;
        move_uploaded_file($foto_tmp, $foto_path);
        
        // Insertar en la base de datos
        $query = $conn->prepare("INSERT INTO relojes (codigo, marca, caracteristicas, precio, foto) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$codigo, $marca, $caracteristicas, $precio, $foto]);
        
        // Redireccionar a la página de inicio
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Reloj</title>
    <link rel="stylesheet" href="C:\wamp64\www\tienda-relojes\assets\css\styles_add.css">
</head>
<body>
    <div class="form-container">
        <h1>Agregar Nuevo Reloj</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" required>
            </div>

            <div class="input-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>
            </div>

            <div class="input-group">
                <label for="caracteristicas">Características:</label>
                <textarea id="caracteristicas" name="caracteristicas" required></textarea>
            </div>

            <div class="input-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>

            <div class="input-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>

            <div class="input-group">
                <button type="submit">Agregar Reloj</button>
            </div>
        </form>
    </div>
</body>
</html>
