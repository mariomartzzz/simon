<?php

 include 'dibujar_circulos.php';
    $colores = array(
        "#000000",
        "#000000",
        "#000000",
        "#000000",
        "#000000",
        "#000000",
        "#000000",
        "#000000",
    );

echo '<h1>Círculos Negros</h1>';

dibujar_circulos($colores);
var_dump($_SESSION['combinacion_inicial']);
?>
