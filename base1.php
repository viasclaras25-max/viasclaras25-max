<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dirección de destino
    $to = "viasclaras.gw25@gmail.com";

    // Recoger y limpiar los datos del formulario
    $nombre    = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
    $apellido  = isset($_POST['apellido']) ? htmlspecialchars(trim($_POST['apellido'])) : '';
    $numero    = isset($_POST['numero']) ? htmlspecialchars(trim($_POST['numero'])) : '';
    $correo    = isset($_POST['correo']) ? htmlspecialchars(trim($_POST['correo'])) : '';
    $comentario= isset($_POST['comentario']) ? htmlspecialchars(trim($_POST['comentario'])) : '';

    // Validar campos obligatorios
    if (empty($nombre) || empty($apellido) || empty($numero) || empty($correo) || empty($comentario)) {
        header("Location: index.html?status=error_campos");
        exit();
    }

    // Validar formato de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=error_email");
        exit();
    }

    // Asunto del correo
    $subject = "Nuevo mensaje de contacto de $nombre $apellido";

    // Cuerpo del mensaje
    $message = "
    <html>
    <head>
        <title>Nuevo mensaje de contacto</title>
    </head>
    <body>
        <h2>Detalles del contacto:</h2>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Apellido:</strong> $apellido</p>
        <p><strong>Teléfono:</strong> $numero</p>
        <p><strong>Correo:</strong> $correo</p>
        <h3>Comentario:</h3><p>$comentario</p>
    </body>
    </html>
    ";

    // Cabeceras para correo HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    // Usa el correo del usuario como Reply-To para poder responderle
    $headers .= "From: Vías Claras <no-reply@tudominio.com>\r\n";
    $headers .= "Reply-To: $correo\r\n";

    // Enviar el correo
    $mailSent = mail($to, $subject, $message, $headers);

    // Redirigir al usuario con un mensaje
    if ($mailSent) {
        header("Location: index.html?status=success");
    } else {
        header("Location: index.html?status=error_envio");
    }
    exit();
} else {
    // Si alguien intenta acceder directamente al script
    header("Location: index.html");
    exit();
}
?>
