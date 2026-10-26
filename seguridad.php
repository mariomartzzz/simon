<?php
// 1. Asegurarnos de que la sesión esté iniciada de forma segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function chkRegistro() {
    // 2. Comprobamos 'usuario' (que es como lo guardas en acceso.php)
    if (!isset($_SESSION['usuario'])) {
        header("Location: acceso.php");
        exit();
    }

    $host = 'localhost';
    $dbname = 'bdsimon';
    $db_usuario = 'root';
    $clave = '';
    
    // 3. Recogemos el usuario de la sesión correcta
    $usuario_actual = $_SESSION['usuario'];

    try {
        // 4. Conexión a la base de datos con PDO
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $db_usuario, $clave);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 5. Consulta segura buscando el nombre exacto (sensible a mayúsculas/minúsculas)
        $sql = "SELECT Rol FROM usuarios WHERE Nombre = :usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario_actual]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        // 6. Verificación de permisos y redirección eficiente
        if ($fila && (int)$fila['Rol'] === 1) {
            // Es Administrador -> va a index.php (para configurar los valores del juego)
            header("Location: index.php");
            exit();
        } else {
            // Es Usuario normal (como ana) -> va directamente a jugar.php
            header("Location: jugar.php");
            exit();
        }

    } catch (PDOException $e) {
        // En caso de fallo de conexión o consulta
        echo "Error de conexión: " . $e->getMessage();
    } finally {
        // Liberar recursos de la base de datos
        $stmt = null;
        $pdo = null;
    }
}

// Ejecutamos la función de seguridad
chkRegistro();
?>