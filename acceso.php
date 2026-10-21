<?php
$_user='pepe';
$_contra=password_hash('abc',PASSWORD_DEFAULT);

$host='locahost';
$dbname='agenda';
$user='root';ç
$password='';


if($_SERVER['REQUEST_METHOD']=='POST') {   
    $usuario=$_POST['user'];
    $contrasenia=$_POST['pwd'];

if($_POST['user']==$_user && password_verify($contrasenia,$_contra)){
    $_SESSION['usuario']=$usuario;
    $_SESSION['pwd']=$contrasenia;
    header("Location: index.php");
}else{
    echo 'Acceso invalido '. password_hash($contrasenia,PASSWORD_DEFAULT) ;
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
</body>
</html>