<?php 
$tiempoExpiracion = 3600*24;

// 1. Configuración de parámetros según el tipo de usuario / procedencia
if (!isset($_POST['nCirculos']) || !isset($_POST['nColores'])) {
    // Si entra un usuario normal (o se recarga), leemos la configuración guardada en la base de datos
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
            $_SESSION['nCirculos'] = 4;
            $_SESSION['nColores'] = 4;
        }
    } catch (PDOException $e) {
        $_SESSION['nCirculos'] = 4;
        $_SESSION['nColores'] = 4;
    }
} else {
    // Si viene del Administrador a través de index.php, guardamos en sesión y actualizamos la BD
    $_SESSION['nCirculos'] = $_POST['nCirculos'];
    $_SESSION['nColores'] = $_POST['nColores'];

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
        // Manejo de errores de actualización si fuera necesario
    }
}

// 2. Gestión del color de fondo mediante cookies
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

// FORZAMOS LA ACTUALIZACIÓN DE LA PALETA SEGÚN LOS VALORES NUEVOS DE LA SESIÓN/BD
$_SESSION['paleta_nombres'] = array_slice(array_keys($colores), 0, (int)$_SESSION['nColores']);
$_SESSION['paleta_hexa']    = array_slice(array_values($colores), 0, (int)$_SESSION['nColores']);

$coloresDef = $_SESSION['paleta_hexa'];

// Combinación aleatoria adaptada al nuevo número de círculos
$combinacion_colores = array();
for ($i = 0; $i < (int)$_SESSION['nCirculos']; $i++) {
    $indiceAleatorio = array_rand($coloresDef);
    $combinacion_colores[] = $coloresDef[$indiceAleatorio];
}

// Se almacena la combinación secreta en la sesión
$_SESSION['combinacion_inicial'] = $combinacion_colores;

// REINICIAMOS LOS CÍRCULOS A PINTAR CON EL NUEVO TAMAÑO EXACTO
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