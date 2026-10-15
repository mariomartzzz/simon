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
      <input name="nCirculos" type="number" min="4" max="8" />
      <label for="nColores">Nº de colores</label>
      <input name="nColores" type="number" min="2" max="8" />
      <button type="submit">Jugar</button>
    </form>
  </body>
</html>
