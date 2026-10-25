<?php

$nombreCookie1='num_circulos';
$valorCookie1=7;
$tiempoExpiracion=3600*24;
setcookie($nombreCookie1,$valorCookie1,[
 'expires' => $tiempoExpiracion,
 'path' => '/',
 'domain' => 'localhost',
 'secure' => false, // Poner true en producción con HTTPS
 'httponly' => true, // Inaccesible desde JavaScript (Protección Anti-XSS)
 'samesite' => 'Lax' // Protección Anti-CSRF
]);
 

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simon</title>
  </head>
  <body>
    <h1>Bienvenido al Simon</h1>
      <form method="POST" action="jugar.php">
      <label for="nCirculos">Nº de cículos</label>
      <input name="nCirculos" type="number" min="4" max="8" value="7" />
      <label for="nColores">Nº de colores</label>
      <input name="nColores" type="number" min="4" max="8" />
      <label for="colorFondo">Color de fondo:</label>
      <input name="colorFondo" value="white"></input>
      <br><br>
      <button type="submit">Jugar</button>
    </form>
    <form method="get" action="acceso.php">
      <button type="submit">Salir</button>
    </form>
  </body>
</html>
