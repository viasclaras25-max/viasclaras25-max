<?php
// Datos de conexión
$host = 'localhost';
$db   = 'base_registro_vc'; // Tu base real
$user = 'root';             // Usuario por defecto en XAMPP
$pass = '';                 // Contraseña vacía por defecto
$charset = 'utf8mb4';

// Configuración PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Obtener datos del formulario
    $numero   = $_POST['numeros'];
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo   = $_POST['correo'];
    $mensaje  = $_POST['mensaje'];

    // Guardar en la tabla real
    $sql = "INSERT INTO tablita_wg (numero, nombre, apellido, correo, mensaje) 
            VALUES (:numero, :nombre, :apellido, :correo, :mensaje)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':numero'   => $numero,
        ':nombre'   => $nombre,
        ':apellido' => $apellido,
        ':correo'   => $correo,
        ':mensaje'  => $mensaje,
    ]);

    // Redirigir con mensaje de éxito
    header("Location: formulario.php?enviado=ok");
    exit;

} catch (PDOException $e) {
    echo "Error al guardar: " . $e->getMessage();
}
?>
