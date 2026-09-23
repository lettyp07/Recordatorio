<?php

require_once "conexion.php";

$sql = "SELECT * FROM clientes ORDER BY id DESC";
$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Clientes</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        .contenedor {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 25px;
        }

        form {
            display: grid;
            gap: 10px;
            margin-bottom: 30px;
        }

        input {
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 12px;
            background: #198754;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>👥 Clientes</h1>

    <form action="guardar_cliente.php" method="POST">

        <label>Nombre</label>

        <input
            type="text"
            name="nombre"
            placeholder="Ej: Leticia"
            required
        >

        <label>Teléfono</label>

        <input
            type="text"
            name="telefono"
            placeholder="Ej: 0984549063"
            required
        >

        <button type="submit">
            ➕ Agregar cliente
        </button>

    </form>

    <h2>Clientes registrados</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Estado</th>
        </tr>

        <?php while ($cliente = $resultado->fetch_assoc()) { ?>

            <tr>

                <td>
                    <?php echo $cliente["id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($cliente["nombre"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($cliente["telefono"]); ?>
                </td>

                <td>
                    <?php
                    echo $cliente["activo"] == 1
                        ? "Activo"
                        : "Inactivo";
                    ?>
                </td>

            </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>