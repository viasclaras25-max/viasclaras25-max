<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
</head>
<body>
    <h1>Formulario de contacto</h1>

    <!-- Mostrar mensaje de éxito si viene desde guardar_mensaje.php -->
    <?php if (isset($_GET['enviado']) && $_GET['enviado'] == 'ok'): ?>
        <p style="color: green;">¡Mensaje guardado correctamente!</p>
    <?php endif; ?>

    <form action="guardar_mensaje.php" method="post">
        <input type="number" name="numeros" placeholder="Número" required><br><br>
        <input type="text" name="nombre" placeholder="Nombre" required><br><br>
        <input type="text" name="apellido" placeholder="Apellido" required><br><br>
        <input type="email" name="correo" placeholder="Correo" required><br><br>
        <textarea name="mensaje" placeholder="Mensaje" required></textarea><br><br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
