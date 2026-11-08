<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  $nombreCookie1='num_circulos';
  $valorCookie1=7;
  $tiempoExpiracion=3600*24;
  
  setcookie($nombreCookie1,$valorCookie1,[
    'expires' => time() + $tiempoExpiracion,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false, // Poner true en producción con HTTPS
    'httponly' => true, // Inaccesible desde JavaScript (Protección Anti-XSS)
    'samesite' => 'Lax' // Protección Anti-CSRF
  ]);

  //si se actualiza configuracion cuando se le da al boton de guardar, actualiza la base de datos
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nCirculos'])) {
    $nCirculos = (int)$_POST['nCirculos'];
    $nColores = (int)$_POST['nColores'];
    $colorFondo = !empty($_POST['colorFondo']) ? trim($_POST['colorFondo']) : 'white';

    // 1. Guardar cookie del color de fondo
    setcookie('color_fondo', $colorFondo, [
        'expires' => time() + $tiempoExpiracion,
        'path' => '/',
        'domain' => 'localhost',
        'secure' => false, 
        'httponly' => true, 
        'samesite' => 'Lax' 
    ]);
    $_COOKIE['color_fondo'] = $colorFondo;

    try {
        $dsn = "mysql:host=localhost;dbname=bdsimon;charset=utf8mb4";
        $pdo = new PDO($dsn, 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE configuracion SET num_circulos = :circulos, num_colores = :colores";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':circulos' => $nCirculos,
            ':colores'  => $nColores
        ]);
    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
    }
}

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
      <form method="post" action="">
      <label for="nCirculos">Nº de cículos</label>
      <input name="nCirculos" type="number" min="4" max="8" value="7" />
      <label for="nColores">Nº de colores</label>
      <input name="nColores" type="number" min="4" max="8" />
      <label for="colorFondo">Color de fondo:</label>
      <input name="colorFondo"></input>
      <br><br>
      <button type="submit">Guardar la configuración</button>
    </form>
    <form method="GET" action="acceso.php">
        <button type="submit">Volver al acceso</button>
    </form>
  </body>
</html>
