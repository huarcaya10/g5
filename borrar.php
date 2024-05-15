<?php
$hostDB = 'localhost';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenaDB = '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // **1. Preparar la consulta DELETE:**
    $miDelete = $miPDO->prepare('DELETE FROM Clientes WHERE id = :id');

    // **2. Ejecutar la consulta con los parámetros:**
    $miDelete->execute([
        'id' => $id
    ]);

   
    header('Location: listar.php');
} else {
    $miConsulta = $miPDO->prepare('SELECT * FROM Clientes WHERE id = :id;');

    $miConsulta->execute([
        'id' => $id
    ]);
}

$cliente = $miConsulta->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar Cliente</title>
</head>
<body>
    <h2>¿Está seguro de que desea eliminar este cliente?</h2>
    <p>ID: <?= $cliente['id'] ?></p>
    <p>Tipo Documento: <?= $cliente['tipo_documento_id'] ?></p>
    <p>Número de Documento: <?= $cliente['numero_documento'] ?></p>
    <p>Nombre Completo / Razón Social: <?= $cliente['nombre_completo_razon_social'] ?></p>
    <p>Dirección: <?= $cliente['direccion'] ?></p>
    <p>Teléfono: <?= $cliente['telefono'] ?></p>
    <p>Email: <?= $cliente['email'] ?></p>
    <p>Fecha de Nacimiento / Creación: <?= $cliente['fecha_nacimiento_creacion'] ?></p>
    <p>Estado: <?= $cliente['estado'] ?></p>
    
    <form method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" value="Confirmar Eliminación">
    </form>
    <button onclick="goBack()">Volver</button>
    <!-- Script para retroceder a la página anterior -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
