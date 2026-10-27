<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SERVER['REQUEST_METHOD']=='POST') {  
    $usuario=$_POST['user'];
    $contrasenia=$_POST['pwd'];

    //params para conectarse a la base de datos
    $host='localhost';
    $dbname='bdsimon';
    $db_usuario='root';
    $clave='';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $db_usuario, $clave);

        // se busca al usuario por su nombre
        $sql = "SELECT Codigo, Nombre, Clave, Rol FROM usuarios WHERE Nombre = :nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nombre' => $usuario]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila && $contrasenia === $fila['Clave']) {
            $_SESSION['usuario'] = $fila['Nombre'];
            header("Location: seguridad.php");
        } else {
            echo 'Acceso invalido';
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    } finally {
        $stmt = null;
        $pdo = null;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al simon</title>
</head>
<body>
    <form method="POST" action="">
        <label for="user">Usuario:</label>
        <input type="text" name="user" placeholder="Introduce tu usuario"><br>
        <label for="pwd">Contraseña:</label>
        <input type="password" name="pwd" placeholder="Introduce tu contraseña"><br>
        <button type="submit">Entrar</button>        
    </form>
    <form method="get" action="registro.php">
        <button type="submit" name="registro">Registrate</button>
    </form>
</body>
</html>