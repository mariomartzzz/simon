//esto es circulos_negros.php

<?php
session_start();

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
?>
?>