<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreNuevo = $_POST['nombreUsuario'];
    $claveNueva = $_POST['contrasenia'];
    $claveChk = $_POST['contraseniaChk'];
    $rolNuevo = 0;

    if ($claveNueva === $claveChk) {
        $host = 'localhost';
        $dbname = 'bdsimon';
        $db_usuario = 'root';
        $clave = '';

        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $pdo = new PDO($dsn, $db_usuario, $clave);

            $sql = "INSERT INTO usuarios (Nombre, Clave, Rol) VALUES (:nom, :clav, :rol)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nombreNuevo,
                ':clav' => $claveNueva,
                ':rol' => $rolNuevo
            ]);

            echo 'Usuario insertado en la db';
        } catch (PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            echo "Error detallado: " . $e->getMessage();
        } finally {
            $stmt = null;
            $pdo = null;
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>REGISTRO</h1>
    <form method="post" action="">
        <label for="nombreUsuario">Nombre de usuario: </label>
        <input name="nombreUsuario"/><br>
        <label for="contrasenia">Contraseña: </label>
        <input type="password" name="contrasenia"/><br>
        <label for="contraseniaChk">Repite la contraseña: </label>
        <input type="password" name="contraseniaChk"/>
        <button type="submit">Registrarse</button>
    </form>
    <br>
    <form method="get" action="acceso.php">
        <button type="submit">Volver al login</button>
    </form>
</body>
</html>