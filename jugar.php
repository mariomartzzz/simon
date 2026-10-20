<?php   
$tiempoExpiracion=3600*24;


if(!empty($_POST['colorFondo'])){
if ($_POST['colorFondo']) {
    
    setcookie('color_fondo', $_POST['colorFondo'], [
    'expires' =>time()+$tiempoExpiracion,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false, // Poner true en producción con HTTPS
    'httponly' => true, // Inaccesible desde JavaScript (Protección Anti-XSS)
    'samesite' => 'Lax' // Protección Anti-CSRF
    ]);
    $_COOKIE['color_fondo'] = $_POST['colorFondo'];
    }
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

$_SESSION['nCirculos']=$_POST['nCirculos'];
$_SESSION['nColores']=$_POST['nColores'];

$_SESSION['paleta_nombres'] = array_slice(array_keys($colores), 0, $_SESSION['nColores']);
$_SESSION['paleta_hexa']    = array_slice(array_values($colores), 0, $_SESSION['nColores']);

$coloresDef = $_SESSION['paleta_hexa'];

// combinación aleatoria aquí
$combinacion_colores = array();
for ($i = 0; $i < $_SESSION['nCirculos']; $i++) {
    $indiceAleatorio = array_rand($coloresDef);
    $combinacion_colores[] = $coloresDef[$indiceAleatorio];
}

// se almacena la combinación secreta en la sesión
$_SESSION['combinacion_inicial'] = $combinacion_colores;
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
    
    // eso reinicia el array de círculos a pintar y el índice x para que cuando se pulse el botón de jugar otra vez, se borren los datos anteriores 
    $_SESSION['circulos_pintar'] = array_fill(0, $_SESSION['nCirculos'], "#000000");
    $_SESSION['x'] = 0;
    ?>
    <br>
    <form method="POST" action="circulos_negro.php">
        <button type="submit" name="jugar" style="margin-top: 20px; padding: 10px 20px;">Jugar</button>
    </form>
</body>
</html>