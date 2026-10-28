<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acierto</title>
</head>
<body>
    <h1>Inténtalo otra vez</h1>
    <?php
    include 'dibujar_circulos.php';
    
        echo "<p>Tu combinación:</p>";
        dibujar_circulos($_SESSION['circulos_pintar']);

        echo "<p>Combinación secreta:</p>";
        dibujar_circulos($_SESSION['combinacion_inicial']);

        echo "<p>Número de aciertos: </p>" . $_SESSION['aciertosExactos'] . "<br>";
        echo "<p>Número de fallos: </p>" . $_SESSION['fallosExactos'] . "<br>";
        session_destroy();
    ?>
    <form method="get" action="jugar.php">
        <button type="submit">Jugar de nuevo</button><br>
    </form>
    <form method="get" action="acceso.php">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>