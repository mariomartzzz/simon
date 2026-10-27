<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$tiempoExpiracion = 3600*24;

// 1. SI EL ADMINISTRADOR ENVÍA EL FORMULARIO DESDE INDEX.PHP
if (isset($_POST['nCirculos']) && isset($_POST['nColores'])) {
    $_SESSION['nCirculos'] = (int)$_POST['nCirculos'];
    $_SESSION['nColores'] = (int)$_POST['nColores'];

    // Actualizamos la base de datos
    try {
        $dsn = "mysql:host=localhost;dbname=bdsimon;charset=utf8mb4";
        $pdo = new PDO($dsn, 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE configuracion SET num_circulos = :circulos, num_colores = :colores";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':circulos' => $_SESSION['nCirculos'],
            ':colores'  => $_SESSION['nColores']
        ]);
    } catch (PDOException $e) {
        echo "Error al actualizar BD: " . $e->getMessage();
    }
} 
// 2. SI ES UN USUARIO NORMAL (O ENTRA DIRECTO SIN POST), LEEMOS SIEMPRE DE LA BD
else {
    try {
        $dsn = "mysql:host=localhost;dbname=bdsimon;charset=utf8mb4";
        $pdo = new PDO($dsn, 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT num_circulos, num_colores FROM configuracion LIMIT 1");
        $config = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($config) {
            $_SESSION['nCirculos'] = (int)$config['num_circulos'];
            $_SESSION['nColores'] = (int)$config['num_colores'];
        } else {
            // por si esta vacia
            $_SESSION['nCirculos'] = 4;
            $_SESSION['nColores'] = 4;
        }
    } catch (PDOException $e) {
        $_SESSION['nCirculos'] = 4;
        $_SESSION['nColores'] = 4;
    }
}

// parte de cookies
if (!empty($_POST['colorFondo'])) {
    setcookie('color_fondo', $_POST['colorFondo'], [
        'expires' => time() + $tiempoExpiracion,
        'path' => '/',
        'domain' => 'localhost',
        'secure' => false, 
        'httponly' => true, 
        'samesite' => 'Lax' 
    ]);
    $_COOKIE['color_fondo'] = $_POST['colorFondo'];
}

if (!isset($_COOKIE['color_fondo'])) {
    $_COOKIE['color_fondo'] = 'white';
}

include 'dibujar_circulos.php';

$colores = array(
    'azul'     => "#0000FF",
    'rojo'     => "#FF0000",
    'verde'    => "#00FF00",
    'amarillo' => "#FFFF00",
    'naranja'  => "#FFA500",
    'rosa'     => "#FFC0CB",
    "morado"   => "#800080",
    "gris"     => "#808080"
);

$_SESSION['paleta_nombres'] = array_slice(array_keys($colores), 0, (int)$_SESSION['nColores']);
$_SESSION['paleta_hexa']    = array_slice(array_values($colores), 0, (int)$_SESSION['nColores']);

$coloresDef = $_SESSION['paleta_hexa'];

// combinacion aleatoria 
$combinacion_colores = array();
for ($i = 0; $i < (int)$_SESSION['nCirculos']; $i++) {
    $indiceAleatorio = array_rand($coloresDef);
    $combinacion_colores[] = $coloresDef[$indiceAleatorio];
}

$_SESSION['combinacion_inicial'] = $combinacion_colores;
$_SESSION['circulos_pintar'] = array_fill(0, (int)$_SESSION['nCirculos'], "#000000");
$_SESSION['x'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combinación Inicial</title>
</head>
<body style="background-color: <?=$_COOKIE['color_fondo'];?>;">
    <h1>Combinación Inicial</h1>
    <?php
    dibujar_circulos($_SESSION['combinacion_inicial']);
    ?>
    <br>
    <form method="POST" action="circulos_negro.php">
        <button type="submit" name="jugar" style="margin-top: 20px; padding: 10px 20px;">Jugar</button>
    </form>
</body>
</html>