<?php

require_once "conexion.php";

// Obtener clientes activos
$sql_clientes = "SELECT id, nombre, telefono 
                 FROM clientes 
                 WHERE activo = 1 
                 ORDER BY nombre ASC";

$resultado_clientes = $conexion->query($sql_clientes);


// Obtener recordatorios
$sql_recordatorios = "
    SELECT
        r.id,
        r.mensaje,
        r.fecha_envio,
        r.estado,
        c.nombre,
        c.telefono
    FROM recordatorios r
    INNER JOIN clientes c
        ON c.id = r.cliente_id
    ORDER BY r.fecha_envio DESC
";

$resultado_recordatorios = $conexion->query($sql_recordatorios);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Recordatorios</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        .contenedor {
            max-width: 1100px;
            margin: auto;
        }

        .tarjeta {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
        }

        h1 {
            margin-top: 0;
        }

        form {
            display: grid;
            gap: 10px;
        }

        label {
            font-weight: bold;
        }

        input,
        select,
        textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            padding: 12px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #157347;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .pendiente {
            color: #856404;
            font-weight: bold;
        }

        .enviado {
            color: #198754;
            font-weight: bold;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <div class="tarjeta">

        <h1>📅 Nuevo recordatorio</h1>

        <form action="guardar_recordatorio.php" method="POST">

            <label for="cliente_id">
                Cliente
            </label>

            <select name="cliente_id" id="cliente_id" required>

                <option value="">
                    -- Seleccionar cliente --
                </option>

                <?php while ($cliente = $resultado_clientes->fetch_assoc()) { ?>

                    <option value="<?php echo $cliente["id"]; ?>">

                        <?php
                        echo htmlspecialchars($cliente["nombre"]);
                        ?>

                        -
                        <?php
                        echo htmlspecialchars($cliente["telefono"]);
                        ?>

                    </option>

                <?php } ?>

            </select>


            <label for="mensaje">
                Mensaje
            </label>

            <textarea
                name="mensaje"
                id="mensaje"
                placeholder="Escribe el mensaje del recordatorio..."
                required
            ></textarea>


            <label for="fecha">
                Fecha
            </label>

            <input
                type="date"
                name="fecha"
                id="fecha"
                required
            >


            <label for="hora">
                Hora
            </label>

            <input
                type="time"
                name="hora"
                id="hora"
                required
            >


            <button type="submit">
                💾 Guardar recordatorio
            </button>

        </form>

    </div>


    <div class="tarjeta">

        <h2>📋 Recordatorios registrados</h2>

        <table>

            <thead>

                <tr>
                <tr>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Mensaje</th>
                    <th>Fecha de envío</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
                </tr>

            </thead>

            <tbody>

            <?php if ($resultado_recordatorios->num_rows > 0) { ?>

                <?php while ($recordatorio = $resultado_recordatorios->fetch_assoc()) { ?>

                    <tr>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $recordatorio["nombre"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $recordatorio["telefono"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $recordatorio["mensaje"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo date(
                                "d/m/Y H:i",
                                strtotime(
                                    $recordatorio["fecha_envio"]
                                )
                            );
                            ?>
                        </td>

                        <td>

                            <?php
                            $estado = $recordatorio["estado"];

                            if ($estado == "pendiente") {

                                echo '<span class="pendiente">
                                        Pendiente
                                      </span>';

                            } elseif ($estado == "enviado") {

                                echo '<span class="enviado">
                                        Enviado
                                      </span>';

                            } else {

                                echo '<span class="error">
                                        Error
                                      </span>';
                            }
                            ?>

                        </td>
                        <td>

    <?php

    $telefono = preg_replace(
        '/[^0-9]/',
        '',
        $recordatorio["telefono"]
    );

    // Convertir 0984... a 595984...
    if (substr($telefono, 0, 1) === "0") {
        $telefono = "595" . substr($telefono, 1);
    }

    $mensaje = urlencode(
        $recordatorio["mensaje"]
    );

    $url_whatsapp =
        "https://wa.me/" .
        $telefono .
        "?text=" .
        $mensaje;

    ?>

    <a
        href="<?php echo htmlspecialchars($url_whatsapp); ?>"
        target="_blank"
        style="
            display: inline-block;
            padding: 8px 12px;
            background: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        "
    >
        📱 Enviar WhatsApp
    </a>

</td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="6">
                        No hay recordatorios registrados.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>