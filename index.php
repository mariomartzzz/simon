<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simon</title>
  </head>
  <body>
      <form method="POST" action="dibujar_circulos.php">
      <label for="nCirculos">Nº de cículos</label>
      <input name="nCirculos" type="text" min="4" max="8" />
      <label for="nColores">Nº de colores</label>
      <input name="nColores" type="text" min="2" max="8" />
      <button type="submit">Jugar</button>
    </form>
  </body>
</html>
