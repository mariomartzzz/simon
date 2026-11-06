<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$color_fondo = isset($_COOKIE['color_fondo']) ? $_COOKIE['color_fondo'] : 'white';

if (isset($_SESSION['usuario'])) {
    try {
        $dsn = "mysql:host=localhost;dbname=bdsimon;charset=utf8mb4";
        $pdo = new PDO($dsn, 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // se busca el código del usuario en la base de datos
        $sqlUser = "SELECT Codigo FROM usuarios WHERE Nombre = :nombre";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute([':nombre' => $_SESSION['usuario']]);
        $usuarioDatos = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($usuarioDatos) {
            $codigoUsuario = $usuarioDatos['Codigo'];

            //update (acierto = acierto + 1)
            $sqlUpdate = "UPDATE jugadas SET acierto = acierto + 1 WHERE codigousu = :codigousu";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':codigousu' => $codigoUsuario
            ]);
        }
    } catch (PDOException $e) {
        // en caso de error
        $error_db = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acierto</title>
</head>
<body style="background-color: <?=$_COOKIE['color_fondo'];?>;">
    <h1>Enhorabuena, has ganado.</h1>
    <?php
    include 'dibujar_circulos.php';

        echo "<p>Tu combinación:</p>";
        dibujar_circulos($_SESSION['circulos_pintar']);

        echo "<p>Combinación secreta:</p>";
        dibujar_circulos($_SESSION['combinacion_inicial']);
    ?>
    <form method="get" action="jugar.php">
        <button type="submit">Jugar de nuevo</button><br>
    </form>
    <form method="get" action="acceso.php">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>