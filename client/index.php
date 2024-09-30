<?php
include '../includes/db.php';

$query = $conn->query("SELECT * FROM relojes");
$relojes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Relojes</title>
    <link rel="stylesheet" href="../assets/css/styles_client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Enlace a FontAwesome -->
</head>
<body>

    <!-- Ventana de Filtros -->
    <div class="filter-sidebar">
        <h3>Filtros</h3>
        <form action="index.php" method="get">
            <label for="marca">Marca:</label>
            <select id="marca" name="marca">
                <option value="">Todas</option>
                <?php
                // Obtener las marcas únicas de la base de datos
                $query = $conn->query("SELECT DISTINCT marca FROM relojes");
                while ($marca = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $marca['marca'] . '">' . $marca['marca'] . '</option>';
                }
                ?>
            </select><br>

            <label for="precio_min">Precio Mínimo:</label>
            <input type="number" id="precio_min" name="precio_min" placeholder="0"><br>

            <label for="precio_max">Precio Máximo:</label>
            <input type="number" id="precio_max" name="precio_max" placeholder="10000"><br>

            <label for="vendidos">Más Vendidos:</label>
            <input type="checkbox" id="vendidos" name="vendidos"><br>

            <button type="submit">Filtrar</button>
        </form>
    </div>

    <!-- Sección para mostrar los relojes -->
    <div class="relojes-list">
        <?php
        // Filtros
        $queryStr = "SELECT * FROM relojes WHERE 1=1";
        $params = [];

        // Filtro de marca
        if (!empty($_GET['marca'])) {
            $queryStr .= " AND marca = ?";
            $params[] = $_GET['marca'];
        }

        // Filtro de precio mínimo
        if (!empty($_GET['precio_min'])) {
            $queryStr .= " AND precio >= ?";
            $params[] = $_GET['precio_min'];
        }

        // Filtro de precio máximo
        if (!empty($_GET['precio_max'])) {
            $queryStr .= " AND precio <= ?";
            $params[] = $_GET['precio_max'];
        }

        // Filtro de los más vendidos
        if (!empty($_GET['vendidos'])) {
            $queryStr .= " ORDER BY vendidos DESC";
        }

        $query = $conn->prepare($queryStr);
        $query->execute($params);

        // Mostrar los relojes filtrados
        while ($reloj = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="reloj-item">';
            echo '<img src="../uploads/' . $reloj['foto'] . '" alt="Foto del reloj">';
            echo '<h3>' . $reloj['marca'] . '</h3>';
            echo '<p>Precio: $' . $reloj['precio'] . '</p>';

            // Ícono de ojo con tooltip para las características
            echo '<div class="eye-icon">';
            echo '<i class="fas fa-eye"></i>';
            echo '<div class="tooltip">' . $reloj['caracteristicas'] . '</div>';
            echo '</div>';

            // Botón de WhatsApp
            $mensajeWhatsapp = 'Hola, estoy interesado en el reloj ' . $reloj['marca'] . ' con código ' . $reloj['codigo'] . '. ¿Está disponible?';
            $numeroWhatsapp = '3245639855';  // Cambia este número al de tu negocio
            $urlWhatsapp = 'https://api.whatsapp.com/send?phone=' . $numeroWhatsapp . '&text=' . urlencode($mensajeWhatsapp);

            echo '<a href="' . $urlWhatsapp . '" target="_blank" class="btn-whatsapp">Comprar por WhatsApp</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
