<?php
$conexion = new mysqli("localhost", "root", "", "base_registro_vc");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero = $_POST['numero'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $mensaje = $_POST['comentario'] ?? '';

    if (!empty($numero) && !empty($nombre) && !empty($apellido) && !empty($correo) && !empty($mensaje)) {
        
        // Verificar si el número ya existe en la tabla 'comentarios'
        $verificar_sql = "SELECT * FROM comentarios WHERE numero = ?";
        $verificar_stmt = $conexion->prepare($verificar_sql);
        $verificar_stmt->bind_param("s", $numero);
        $verificar_stmt->execute();
        $resultado = $verificar_stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Ya existe un registro con ese número
            echo "<script>alert('El número ya existe. Por favor, utiliza otro número.'); window.history.back();</script>";
        } else {
            // Insertar si no existe
            $sql = "INSERT INTO comentarios (numero, nombre, apellido, correo, mensaje) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssss", $numero, $nombre, $apellido, $correo, $mensaje);

            if ($stmt->execute()) {
                echo "<script>alert('Mensaje enviado correctamente.'); window.location.href='../gracias.html';</script>";
            } else {
                echo "Error al guardar: " . $stmt->error;
            }

            $stmt->close();
        }

        $verificar_stmt->close();
    } else {
        echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
    }
} else {
    echo "Acceso no válido.";
}

$conexion->close();
?>
