<?php
$color_fondo=$_COOKIE['color_fondo'];

    $_SESSION['aciertosExactos'] = 0;
    $_SESSION['fallosExactos']=0;

    for ($i = 0; $i < $_SESSION['nCirculos']; $i++) {
        if ($_SESSION['combinacion_inicial'][$i] == $_SESSION['circulos_pintar'][$i]) {
            $_SESSION['aciertosExactos']++; 
        }else{
            $_SESSION['fallosExactos']++;
        }
    }

    if ($aciertosExactos == $_SESSION['nCirculos']) {
        header("Location: acierto.php");
    } else {
        header("Location: fallo.php");
    }
    ?>