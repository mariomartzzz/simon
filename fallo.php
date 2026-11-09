<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acierto</title>
</head>
<body style="background-color: <?=$_COOKIE['color_fondo'];?>;">
    <h1>Inténtalo otra vez</h1>
    <?php
    include 'dibujar_circulos.php';
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        echo "<p>Tu combinación:</p>";
        dibujar_circulos($_SESSION['circulos_pintar']);

        echo "<p>Combinación secreta:</p>";
        dibujar_circulos($_SESSION['combinacion_inicial']);

        echo "<p>Número de aciertos: </p>" . $_SESSION['aciertosExactos'] . "<br>";
        echo "<p>Número de fallos: </p>" . $_SESSION['fallosExactos'] . "<br>";
    ?>
    <form method="get" action="jugar.php">
        <button type="submit">Jugar de nuevo</button><br>
    </form>
    <form method="get" action="acceso.php">
        <button type="submit">Cerrar sesión</button>
    </form><br><br>
    <form method="get" action="estadisticas.php">
        <button type="submit">Ver las estadisticas</button>
    </form>
</body>
</html>