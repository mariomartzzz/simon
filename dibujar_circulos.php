<?php
session_start();
//para los circulos se hacen en una tabla
//azul rojo verde amarillo naranja rosa morado gris

if (isset($_POST['nCirculos'])) {
    $_SESSION['nCirculos'] = $_POST['nCirculos'];
}
if (isset($_POST['nColores'])) {
    $_SESSION['nColores'] = $_POST['nColores'];
}
            

$colores = array(
    'azul'=> "#0000FF",
    'rojo'=> "#FF0000",
    'verde'=> "#00FF00",
    'amarillo'=> "#FFFF00",
    'naranja'=> "#FFA500",
    'rosa'=> "#FFC0CB",
    "morado"=> "#800080",
    "gris"=> "#808080"
);
    $combinacion_colores = array();

    $_SESSION['paleta_nombres'] = array_slice(array_keys($colores), 0, $_SESSION['nColores']);
    $_SESSION['paleta_hexa'] = array_slice(array_values($colores), 0, $_SESSION['nColores']);

function dibujar_circulos($colores_inicial) {

                    //if abreviado (true/false, acción, else)
$nCirculos = isset($_SESSION['nCirculos']) ? $_SESSION['nCirculos'] : 4;
$nColores = isset($_SESSION['nColores']) ? $_SESSION['nColores'] : 2;


    // convertimos las claves otro array para poder acceder a los colores por posicion
    $nuevosColores = array_values($colores_inicial);
    $coloresDef=array_slice($nuevosColores, 0, $nColores);

    echo '<table>';
        echo '<tr>';
    // svg para que se muestran los círculos
    
    
    for ($i = 0; $i < $nCirculos; $i++) {
           echo '<td>';
           echo '<svg height="200" width="200">';   
            $indiceAleatorio = array_rand($coloresDef);
            $colorAleatorio = $coloresDef[$indiceAleatorio];
            $combinacion_colores[] = $colorAleatorio;
            echo "<circle stroke='black' stroke-width='2' fill='" . $colorAleatorio . "' cx='50' cy='50' r='40'></circle>";
            echo '</svg>';
            echo '</td>';
        }
            echo '</tr>';
        echo '</table>';
        
    return $combinacion_colores;
    }

    
    
    




?>