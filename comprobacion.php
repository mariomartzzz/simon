<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$color_fondo=$_COOKIE['color_fondo'];

    $_SESSION['aciertosExactos'] = 0;
    $_SESSION['fallosExactos']=0;

    for ($i = 0; $i < $_SESSION['nCirculos']; $i++) {
        if ($_SESSION['combinacion_inicial'][$i] == $_SESSION['circulos_pintar'][$i]) {
            $_SESSION['aciertosExactos']++; 
        }else{
            $_SESSION['fallosExactos']++;
        }
    }

    if ($_SESSION['aciertosExactos'] == $_SESSION['nCirculos']) {

        try {
            $dsn = "mysql:host=localhost;dbname=bdsimon;charset=utf8mb4";
            $pdo = new PDO($dsn, 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // se busca el código del usuario en la base de datos
            $stmtUsuario = $pdo->prepare("SELECT Codigo FROM usuarios WHERE Nombre = :nombre");
            $stmtUsuario->execute([':nombre' => $_SESSION['usuario']]);
            $usuarioData = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

            if ($usuarioData) {
                $codigoUsuario = $usuarioData['Codigo'];

                // se mira si ya existe una jugada activa para este usuario en la sesión
                if (isset($_SESSION['codjugada_activa'])) {
                    // ¡OJO AQUÍ! El UPDATE tiene que filtrar estrictamente por codjugada (el ID exacto de la sesión), 
                    // nunca por codigousu solo, porque si no modificaría todas las jugadas históricas del usuario.
                    $stmtUpd = $pdo->prepare("UPDATE jugadas SET acierto = acierto + 1 WHERE codjugada = :codjugada");
                    $stmtUpd->execute([':codjugada' => $_SESSION['codjugada_activa']]);
                } else {
                    $stmtIns = $pdo->prepare("INSERT INTO jugadas (codigousu, acierto) VALUES (:codigousu, 1)");
                    $stmtIns->execute([':codigousu' => $codigoUsuario]);
                    
                    // se guarda para proximos updates
                    $_SESSION['codjugada_activa'] = $pdo->lastInsertId();
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        header("Location: acierto.php");
        exit();
    } else {
        header("Location: fallo.php");
        exit();
    }
    ?>