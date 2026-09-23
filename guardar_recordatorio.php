<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: recordatorios.php");
    exit;
}

$cliente_id = intval($_POST["cliente_id"]);
$mensaje = trim($_POST["mensaje"]);
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

if (
    $cliente_id <= 0 ||
    $mensaje === "" ||
    $fecha === "" ||
    $hora === ""
) {
    die("Todos los campos son obligatorios.");
}

$fecha_envio = $fecha . " " . $hora . ":00";

$sql = "
    INSERT INTO recordatorios
    (cliente_id, mensaje, fecha_envio)
    VALUES (?, ?, ?)
";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "iss",
    $cliente_id,
    $mensaje,
    $fecha_envio
);

if ($stmt->execute()) {

    header("Location: recordatorios.php");
    exit;

} else {

    echo "Error al guardar el recordatorio: "
        . $stmt->error;
}