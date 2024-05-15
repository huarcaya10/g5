<?php

$hostDB = 'localhost';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenaDB = '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$tipoDocumento = isset($_REQUEST['tipo_documento']) ? $_REQUEST['tipo_documento'] : null;
$numeroDocumento = isset($_REQUEST['numero_documento']) ? $_REQUEST['numero_documento'] : null;
$nombreCompleto = isset($_REQUEST['nombre_completo']) ? $_REQUEST['nombre_completo'] : null;
$direccion = isset($_REQUEST['direccion']) ? $_REQUEST['direccion'] : null;
$telefono = isset($_REQUEST['telefono']) ? $_REQUEST['telefono'] : null;
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
$fechaNacimientoCreacion = isset($_REQUEST['fecha_nacimiento_creacion']) ? $_REQUEST['fecha_nacimiento_creacion'] : null;
$estado = isset($_REQUEST['estado']) ? $_REQUEST['estado'] : null;

$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // **1. Preparar la consulta UPDATE:**
  $miUpdate = $miPDO->prepare('UPDATE Clientes SET tipo_documento_id = :tipoDocumento, numero_documento = :numeroDocumento, nombre_completo_razon_social = :nombreCompleto, direccion = :direccion, telefono = :telefono, email = :email, fecha_nacimiento_creacion = :fechaNacimientoCreacion, estado = :estado WHERE id = :id');

  // **2. Ejecutar la consulta con los parámetros:**
  $miUpdate->execute([
    'id' => $id,
    'tipoDocumento' => $tipoDocumento,
    'numeroDocumento' => $numeroDocumento,
    'nombreCompleto' => $nombreCompleto,
    'direccion' => $direccion,
    'telefono' => $telefono,
    'email' => $email,
    'fechaNacimientoCreacion' => $fechaNacimientoCreacion,
    'estado' => $estado,
  ]);

  // **3. Redirigir a la página de listado:**
  header('Location: listar.php');
}
else {
    $miConsulta = $miPDO->prepare('SELECT * FROM Clientes WHERE id = :id;');

    $miConsulta->execute(
        [
            'id' => $id
        ]
    );
}
$cliente = $miConsulta->fetch();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cliente</title>
</head>
<body>
<form method="post">
    <p>
        <label for="tipo_documento">Tipo Documento</label>
        <select id="tipo_documento" name="tipo_documento" required>
            <option value="1" <?= ($cliente['tipo_documento_id'] == 1) ? 'selected' : '' ?>>DNI</option>
            <option value="2" <?= ($cliente['tipo_documento_id'] == 2) ? 'selected' : '' ?>>Carnet de Extranjería</option>
            <option value="3" <?= ($cliente['tipo_documento_id'] == 3) ? 'selected' : '' ?>>RUC</option>
        </select>
    </p>
    <p>
        <label for="numero_documento">Número de Documento</label>
        <input id="numero_documento" type="text" name="numero_documento" value="<?= $cliente['numero_documento'] ?>" required>
    </p>
    <p>
        <label for="nombre_completo">Nombre Completo / Razón Social</label>
        <input id="nombre_completo" type="text" name="nombre_completo" value="<?= $cliente['nombre_completo_razon_social'] ?>" required>
    </p>
    <p>
        <label for="direccion">Dirección</label>
        <input id="direccion" type="text" name="direccion" value="<?= $cliente['direccion'] ?>" required>
    </p>
    <p>
        <label for="telefono">Teléfono</label>
        <input id="telefono" type="numbre" name="telefono" value="<?= $cliente['telefono'] ?>" required>
    </p>
    <p>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?= $cliente['email'] ?>" required>
    </p>
    <p>
        <label for="fecha_nacimiento_creacion">Fecha de Nacimiento / Creación</label>
        <input id="fecha_nacimiento_creacion" type="date" name="fecha_nacimiento_creacion" value="<?= $cliente['fecha_nacimiento_creacion'] ?>" required>
    </p>
    <p>
        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            <option value="Activo" <?= ($cliente['estado'] == 'Activo') ? 'selected' : '' ?>>Activo</option>
            <option value="Inactivo" <?= ($cliente['estado'] == 'Inactivo') ? 'selected' : '' ?>>Inactivo</option>
        </select>
    </p>
    <p>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" value="Modificar">
    </p>
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
