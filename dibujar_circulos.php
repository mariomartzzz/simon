<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function dibujar_circulos($colores_inicial) {
    echo '<table style="border-collapse: collapse; display: inline-block;">';
    echo '<tr>';
    
    // if abreviado (condicion, verdadero, falso) para saber el numero de círculos a dibujar
    $total = is_array($colores_inicial) ? count($colores_inicial) : $_SESSION['nCirculos'];
    
    for ($i = 0; $i < $total; $i++) {
        echo '<td style="padding: 5px;">';
        echo '<svg height="100" width="100">';  
        echo "<circle stroke='black' stroke-width='2' fill='" . ($colores_inicial[$i] ?? '#000000') . "' cx='50' cy='50' r='40'></circle>";
        echo '</svg>';
        echo '</td>';
    }
    
    echo '</tr>';
    echo '</table>';
}
?>