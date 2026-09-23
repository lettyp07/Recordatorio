<?php
require_once "conexion.php";

// Cantidad de clientes
$sql_clientes = "SELECT COUNT(*) AS total FROM clientes";
$resultado_clientes = $conexion->query($sql_clientes);
$total_clientes = $resultado_clientes->fetch_assoc()["total"];

// Cantidad de recordatorios pendientes
$sql_pendientes = "
    SELECT COUNT(*) AS total
    FROM recordatorios
    WHERE estado = 'pendiente'
";
$resultado_pendientes = $conexion->query($sql_pendientes);
$total_pendientes = $resultado_pendientes->fetch_assoc()["total"];

// Cantidad de recordatorios enviados
$sql_enviados = "
    SELECT COUNT(*) AS total
    FROM recordatorios
    WHERE estado = 'enviado'
";
$resultado_enviados = $conexion->query($sql_enviados);
$total_enviados = $resultado_enviados->fetch_assoc()["total"];
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Recordatorios</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        /* MENÚ */

        .menu {
            background: #198754;
            color: white;
            padding: 18px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .menu-links {
            display: flex;
            gap: 10px;
        }

        .menu-links a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: 0.2s;
        }

        .menu-links a:hover {
            background: rgba(255,255,255,0.2);
        }

        /* CONTENIDO */

        .contenedor {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .titulo {
            margin-bottom: 30px;
        }

        .titulo h1 {
            margin: 0 0 8px;
        }

        .titulo p {
            margin: 0;
            color: #777;
        }

        /* TARJETAS */

        .estadisticas {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .estadistica {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .estadistica h3 {
            margin: 0 0 10px;
            color: #777;
            font-size: 15px;
        }

        .numero {
            font-size: 35px;
            font-weight: bold;
        }

        /* ACCIONES */

        .acciones {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .accion {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: 0.2s;
        }

        .accion:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.12);
        }

        .icono {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .accion h2 {
            margin: 0 0 8px;
        }

        .accion p {
            color: #777;
            margin: 0;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {

            .menu {
                flex-direction: column;
                gap: 15px;
            }

            .menu-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .estadisticas {
                grid-template-columns: 1fr;
            }

            .acciones {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

    <!-- MENÚ SUPERIOR -->

    <nav class="menu">

        <div class="logo">
            📱 Recordatorios
        </div>

        <div class="menu-links">

            <a href="index.php">
                🏠 Inicio
            </a>

            <a href="clientes.php">
                👥 Clientes
            </a>

            <a href="recordatorios.php">
                📅 Recordatorios
            </a>

        </div>

    </nav>


    <!-- CONTENIDO -->

    <main class="contenedor">

        <div class="titulo">

            <h1>
                Panel principal
            </h1>

            <p>
                Administración de clientes y recordatorios
            </p>

        </div>


        <!-- ESTADÍSTICAS -->

        <div class="estadisticas">

            <div class="estadistica">

                <h3>
                    👥 Clientes registrados
                </h3>

                <div class="numero">
                    <?php echo $total_clientes; ?>
                </div>

            </div>


            <div class="estadistica">

                <h3>
                    ⏳ Recordatorios pendientes
                </h3>

                <div class="numero">
                    <?php echo $total_pendientes; ?>
                </div>

            </div>


            <div class="estadistica">

                <h3>
                    ✅ Recordatorios enviados
                </h3>

                <div class="numero">
                    <?php echo $total_enviados; ?>
                </div>

            </div>

        </div>


        <!-- ACCIONES -->

        <div class="acciones">

            <a
                href="clientes.php"
                class="accion"
            >

                <div class="icono">
                    👥
                </div>

                <h2>
                    Clientes
                </h2>

                <p>
                    Agregar, consultar y administrar clientes.
                </p>

            </a>


            <a
                href="recordatorios.php"
                class="accion"
            >

                <div class="icono">
                    📅
                </div>

                <h2>
                    Recordatorios
                </h2>

                <p>
                    Crear y administrar los recordatorios de los clientes.
                </p>

            </a>

        </div>

    </main>

</body>

</html>