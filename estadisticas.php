<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = new PDO("mysql:host=localhost;dbname=bdsimon;charset=utf8mb4", "root", "");

$sql = "SELECT u.Codigo, u.Nombre, SUM(j.acierto) AS total_aciertos 
        FROM usuarios u 
        JOIN jugadas j ON u.Codigo = j.codigousu 
        GROUP BY u.Codigo, u.Nombre";

$stmt = $pdo->query($sql);
$estadisticas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
</head>
<body>

    <h1>Estadísticas </h1>
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Aciertos</th>
            <th>Gráfica</th>
        </tr>

        <?php foreach ($estadisticas as $row): ?>
            <tr>
                <td><?php echo $row['Codigo']; ?></td>
                <td><?php echo $row['Nombre']; ?></td>
                <td><?php echo $row['total_aciertos']; ?></td>
                <td>
                    <!-- barra  proporcional segun  aciertos -->
                    <div style="background-color: #007acc; width: <?php echo $row['total_aciertos'] * 10; ?>px; height: 12px;"></div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <form action="jugar.php" method="GET" style="display:inline;">
        <button type="submit">Volver a jugar</button>
    </form>
    
    <form action="acceso.php" method="GET" style="display:inline;">
        <button type="submit">Cerrar sesión</button>
    </form>

</body>
</html>