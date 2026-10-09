<?php

//para los circulos se hacen en una tabla
//azul rojo verde amarillo naranja rosa morado gris

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

function dibujar_circulos($colores_inicial) {

    if (isset($_POST['nCirculos'])) {
    $nCirculos = $_POST['nCirculos'];
    }  
    if (isset($_POST['nColores'])) {
        $nColores = $_POST['nColores'];
    } 

    // convertimos las claves otro array para poder acceder a los colores por posicion
    $nuevosColores = array_values($colores_inicial);
    $coloresDef=array_slice($nuevosColores, 0, $nColores);

    echo '<h1>Bienvenido al Simon</h1>';
    echo '<table>';
        echo '<tr>';
    // svg para que se muestrn los círculos
    
    
    for ($i = 0; $i < $nCirculos; $i++) {
           echo '<td>';
           echo '<svg height="200" width="200">';   
            $indiceAleatorio = array_rand($coloresDef);
            $colorAleatorio = $coloresDef[$indiceAleatorio];
            echo "<circle fill='" . $colorAleatorio . "' cx='50' cy='50' r='40'></circle>";
            echo '</svg>';
            echo '</td>';
        }
            echo '</tr>';
        echo '</table>';
        echo '<form method="POST" action="circulos_negro.php">';
        echo '<button type="submit" name="jugar">Jugar</button>';
        echo '</form>';

    }
    
    


dibujar_circulos($colores);


?>