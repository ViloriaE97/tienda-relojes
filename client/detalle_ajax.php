<?php
include '../includes/db.php';

$id = $_GET['id'];

// Obtener los detalles del reloj por su ID
$query = $conn->prepare("SELECT * FROM relojes WHERE id = ?");
$query->execute([$id]);
$reloj = $query->fetch(PDO::FETCH_ASSOC);

// Formatear el contenido del detalle
echo '<h2>' . $reloj['marca'] . '</h2>';
echo '<p><strong>Código:</strong> ' . $reloj['codigo'] . '</p>';
echo '<p><strong>Características:</strong> ' . $reloj['caracteristicas'] . '</p>';
echo '<p><strong>Precio:</strong> $' . $reloj['precio'] . '</p>';
echo '<img src="../uploads/' . $reloj['foto'] . '" alt="Foto del reloj" class="detalle-img">';
?>
