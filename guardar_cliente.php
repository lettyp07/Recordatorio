<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: clientes.php");
    exit;
}

$nombre = trim($_POST["nombre"]);
$telefono = trim($_POST["telefono"]);

if ($nombre === "" || $telefono === "") {
    die("Nombre y teléfono son obligatorios.");
}

$sql = "INSERT INTO clientes (nombre, telefono)
        VALUES (?, ?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "ss",
    $nombre,
    $telefono
);

if ($stmt->execute()) {

    header("Location: clientes.php");
    exit;

} else {

    echo "Error al guardar el cliente: "
         . $stmt->error;
}