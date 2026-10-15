<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
?>
<table>
    <tr>
        <?php
        for ($i = 0; $i < $_SESSION['nColores']; $i++) {
            echo "<td>";
                echo "<button type='button' style='background-color: " . $_SESSION['paleta_hexa'][$i] . "; border: 2px solid #000000; width: 100px; height: 50px;margin: 45px;'>" . $_SESSION['paleta_nombres'][$i] . "</button>";
            echo "</td>";
        }
        var_dump($_SESSION['combinacion_inicial']);
        ?>
    </tr>
</table>
    <form method="POST" action="">
        <button type="submit" name="jugar">Jugar</button>
    </form>
</body>
</html>