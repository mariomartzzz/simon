<?php
include 'dibujar_circulos.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comprobación</title>
</head>
<body>
    <h1>Resultado</h1>

    <?php

    $aciertosExactos = 0;

    for ($i = 0; $i < $_SESSION['nCirculos']; $i++) {
        if ($_SESSION['combinacion_inicial'][$i] === $_SESSION['circulos_pintar'][$i]) {
            $aciertosExactos++; 
        }
    }

    echo "<p>Tu combinación:</p>";
    dibujar_circulos($_SESSION['circulos_pintar']);

    echo "<p>Combinación secreta:</p>";
    dibujar_circulos($_SESSION['combinacion_inicial']);

    if ($aciertosExactos == $_SESSION['nCirculos']) {
        echo "<h2>Has ganado</h2>";
    } else {
        echo "<p>Aciertos: " . $aciertosExactos . "</p>";
    }
    ?>

    <br>
    <form method="GET" action="index.php">
        <button type="submit">Jugar otra vez</button>
    </form>
</body>
</html>