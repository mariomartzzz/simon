<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function chkRegistro() {
    // si no hay usuario se va a acceso
    if (!isset($_SESSION['usuario'])) {
        header("Location: acceso.php");
        exit();
    }

    $host = 'localhost';
    $dbname = 'bdsimon';
    $db_usuario = 'root';
    $clave = '';
    
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

        // verificacion de rol
        if ($fila && (int)$fila['Rol'] === 1) {
            header("Location: index.php");
            exit();
        } else {
            header("Location: jugar.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    } finally {
        $stmt = null;
        $pdo = null;
    }
}

chkRegistro();
?>