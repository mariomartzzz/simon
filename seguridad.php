<?php
function chkRegistro() {
    // // Si no hay ningun usuario logueado en la sesión, lo mandamos al index
    // if (!isset($_SESSION['user'])) {
    //     header("Location: index.php");
    //     exit();
    // }
echo "Usuario en sesión: " . $_SESSION['user'] . "<br>";
    $host = 'localhost';
    $dbname = 'bdsimon';
    $db_usuario = 'root';
    $clave = '';
    
    $usuario_actual = $_SESSION['user'];

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $db_usuario, $clave);

        // busca al usuario en la base de datos con el nombre de la sesión
        $sql = "SELECT Rol FROM usuarios WHERE Nombre = :usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario_actual]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario existe y su Rol es 1 (Administrador)
        if ($fila && (int)$fila['Rol'] === 1) {
            header("Location: index.php");
            exit();
        } else {
            header("Location: jugar.php");
            exit();
        }

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}

chkRegistro();
?>