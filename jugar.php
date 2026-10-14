<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>combinación inicial</title>
    
</head>
<body>
    <h1>Combinación Inicial</h1>
    <?php
    include 'dibujar_circulos.php';
    $_SESSION['combinacion_inicial'] =dibujar_circulos($colores);
    var_dump($_SESSION['combinacion_inicial']);
    ?>
</body>
</html>