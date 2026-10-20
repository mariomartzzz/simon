<?php
include 'dibujar_circulos.php';

// Inicializar el array de círculos negros si no existe
if (!isset($_SESSION['circulos_pintar'])) {
    $_SESSION['circulos_pintar'] = array_fill(0, $_SESSION['nCirculos'], "#000000");
    $_SESSION['x'] = 0;
}

// Procesar el botón de color pulsado ANTES de pintar
if (isset($_POST['color_seleccionado'])) {
    $x = $_SESSION['x'];
    if ($x < $_SESSION['nCirculos']) {
        $_SESSION['circulos_pintar'][$x] = $_POST['color_seleccionado'];
        $_SESSION['x']++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combinación de Círculos</title>
</head>
<body style="background-color: <?=$_COOKIE['color_fondo'];?>;">
    <?php
    echo '<h1>Introduzca su combinación</h1>';

    dibujar_circulos($_SESSION['circulos_pintar']);
    ?>
    
    <table>
        <tr>
            <form method="POST">
            <?php
            for ($i = 0; $i < $_SESSION['nColores']; $i++) {
                echo "<td>";
                echo "<button name='color_seleccionado' type='submit' value='" . $_SESSION['paleta_hexa'][$i] . "' style='background-color: " . $_SESSION['paleta_hexa'][$i] . "; border: 2px solid #000000; width: 100px; height: 50px; margin: 15px; cursor: pointer;'>" . $_SESSION['paleta_nombres'][$i] . "</button>";
                echo "</td>";
            }
            ?>
            </form>
        </tr>
    </table>
    
    <?php 
    if ($_SESSION['x'] >= $_SESSION['nCirculos']) {
        echo '<br><form method="POST" action="comprobacion.php">
                <button type="submit" style="padding: 15px 30px; font-size: 16px; cursor: pointer;">Comprobar Resultado</button>
              </form>';
    }
    ?>
</body>
</html>