<?php
$_user='pepe';
$_contra=password_hash('abc',PASSWORD_DEFAULT);


//params para conectarse a la base de datos
$host='localhost';
$dbname='agenda';
$usuario='root';
$clave='';


    // 1. Cadena de conexión (DSN) e instanciación directa de PDO
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $usuario, $clave);

    //FORMAS PARA HECER SELECT

    $sql = "SELECT Codigo, Nombre, Clave, Rol FROM usuarios";
    $stmt = $pdo->prepare($sql);
     // 2. Ejecutar pasando los valores en un array asociativo
     $stmt->execute([]);

    // 3. Recorrido y visualización de resultados en pantalla
    echo "<table border='1'>";
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" .$fila['Codigo']. "<td>" .$fila['Nombre'] . "</td>" ."<td>" . $fila['Clave'] . "</td>"."<td>" . $fila['Rol'] ."</td>";
    echo "</tr>";
    }
    echo "</table>";
    echo"<br>";

    // // 4. Cierre explícito de cursor y conexión
    // $stmt = null;
    // $pdo = null;

if($_SERVER['REQUEST_METHOD']=='POST') {   
    $usuario=$_POST['user'];
    $contrasenia=$_POST['pwd'];

if($_POST['user']==$_user && password_verify($contrasenia,$_contra)){
    $_SESSION['usuario']=$usuario;
    $_SESSION['pwd']=$contrasenia;
    header("Location: index.php");
}elseif($_POST['registro']){
    header("Location: registro.php");
}else{
    echo 'Acceso invalido '. password_hash($contrasenia,PASSWORD_DEFAULT) ;
}
    }

    //PASAMOS AL INSERT
//     $nombreNuevo = "Mario";
//     $claveNueva = "Clave Mario";
//     $rolNuevo = 67;

//     try {
//     // 1. Sentencia con marcadores nominales
//     $sql = "INSERT INTO usuarios (Nombre, Clave, Rol) VALUES (:nom, :clav, :rol)";
//     $stmt = $pdo->prepare($sql);
//     // 2. Ejecución pasando el mapa de valores
//     $stmt->execute([
//     ':nom' => $nombreNuevo,
//     ':clav' => $claveNueva,
//     ':rol' => $rolNuevo
//     ]);
//     // 3. Obtener el ID generado por el AUTO_INCREMENT
//     $idGenerado = $pdo->lastInsertId();
//     echo "Usuario insertado con éxito con el ID asignado: " . $idGenerado;
//     } catch (PDOException $e) {
//     error_log("Error en INSERT: " . $e->getMessage());
//     echo "Error: No se pudo guardar el registro del usuario.";
//     } finally {
//     $stmt = null;
//     $pdo = null;
// }
        $stmt = null;
        $pdo = null;

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
    <form method="POST" action="registro.php">
        <button type="submit" name="registro">Registrate</button>
    </form>
</body>
</html>