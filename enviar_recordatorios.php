<?php

require_once "conexion.php";

$sql = "
    SELECT
        r.id,
        r.mensaje,
        c.nombre,
        c.telefono
    FROM recordatorios r
    INNER JOIN clientes c
        ON c.id = r.cliente_id
    WHERE r.estado = 'pendiente'
    AND r.fecha_envio <= NOW()
    AND c.activo = 1
";

$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {

    $telefono = preg_replace('/[^0-9]/', '', $fila["telefono"]);
    
    // Si el número está escrito como 0984..., lo convertimos
    // al formato internacional de Paraguay: 595984...
    if (substr($telefono, 0, 1) === "0") {
        $telefono = "595" . substr($telefono, 1);
    }

    $mensaje = urlencode($fila["mensaje"]);

    $url = "https://wa.me/" . $telefono . "?text=" . $mensaje;

    echo "<h3>Cliente: " . htmlspecialchars($fila["nombre"]) . "</h3>";
    echo "Teléfono: " . htmlspecialchars($fila["telefono"]) . "<br>";
    echo "Mensaje: " . htmlspecialchars($fila["mensaje"]) . "<br>";

    echo "<a href='$url' target='_blank'>";
    echo "📱 Abrir WhatsApp";
    echo "</a>";

    echo "<hr>";
}
?>