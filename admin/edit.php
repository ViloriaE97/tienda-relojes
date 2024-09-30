<?php
include '../includes/db.php';

$id = $_GET['id'];

// Obtener los datos del reloj por su ID
$query = $conn->prepare("SELECT * FROM relojes WHERE id = ?");
$query->execute([$id]);
$reloj = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $marca = $_POST['marca'];
    $caracteristicas = $_POST['caracteristicas'];
    $precio = $_POST['precio'];
    $foto = $reloj['foto'];  // Mantener la foto actual por defecto

    // Si se sube una nueva imagen
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($foto_tmp, "../uploads/" . $foto);  // Subir la nueva imagen
    }

    // Actualizar los datos del reloj en la base de datos
    $query = $conn->prepare("UPDATE relojes SET codigo = ?, marca = ?, caracteristicas = ?, precio = ?, foto = ? WHERE id = ?");
    $query->execute([$codigo, $marca, $caracteristicas, $precio, $foto, $id]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reloj</title>
    <link rel="stylesheet" href="C:\wamp64\www\tienda-relojes\assets\css\styles_edit.css">
</head>
<body>
    <div class="form-container">
        <h1>Editar Reloj</h1>
        <form action="edit.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" value="<?= $reloj['codigo'] ?>" required>
            </div>

            <div class="input-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" value="<?= $reloj['marca'] ?>" required>
            </div>

            <div class="input-group">
                <label for="caracteristicas">Características:</label>
                <textarea id="caracteristicas" name="caracteristicas" required><?= $reloj['caracteristicas'] ?></textarea>
            </div>

            <div class="input-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?= $reloj['precio'] ?>" required>
            </div>

            <div class="input-group">
                <label for="foto">Foto Actual:</label><br>
                <div class="photo-preview">
                    <img src="../uploads/<?= $reloj['foto'] ?>" alt="Foto del reloj" width="150">
                </div>
            </div>

            <div class="input-group">
                <label for="foto">Cambiar Foto (opcional):</label>
                <input type="file" id="foto" name="foto">
            </div>

            <div class="input-group">
                <button type="submit">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>