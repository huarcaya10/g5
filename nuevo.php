<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tipoDocumento = filter_input(INPUT_POST, 'tipo_documento', FILTER_SANITIZE_STRING);
  $numeroDocumento = filter_input(INPUT_POST, 'numero_documento', FILTER_SANITIZE_STRING);
  $nombreCompleto = filter_input(INPUT_POST, 'nombre_completo', FILTER_SANITIZE_STRING);
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
  $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $fechaNacimientoCreacion = filter_input(INPUT_POST, 'fecha_nacimiento_creacion', FILTER_SANITIZE_STRING);
  $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

  if ($tipoDocumento === false || $numeroDocumento === false || $nombreCompleto === false || $direccion === false || $telefono === false || $email === false || $fechaNacimientoCreacion === false || $estado === false) {
    echo "Error: Invalid input detected.";
    exit;
  }

  $hostDB = 'localhost';
  $nombreDB = 'ejemplo';
  $usuarioDB = 'root';
  $contrasenaDB = '';
  
  $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8";

  try {
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
    $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $miconsulta = $miPDO->prepare('INSERT INTO Clientes (tipo_documento_id, numero_documento, nombre_completo_razon_social, direccion, telefono, email, fecha_nacimiento_creacion, estado) VALUES (:tipoDocumento, :numeroDocumento, :nombreCompleto, :direccion, :telefono, :email, :fechaNacimientoCreacion, :estado)');
    $miconsulta->execute([
      ':tipoDocumento' => $tipoDocumento,
      ':numeroDocumento' => $numeroDocumento,
      ':nombreCompleto' => $nombreCompleto,
      ':direccion' => $direccion,
      ':telefono' => $telefono,
      ':email' => $email,
      ':fechaNacimientoCreacion' => $fechaNacimientoCreacion,
      ':estado' => $estado,
    ]);

    header('Location: listar.php');   
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Cliente</title>
</head>
<body>
  <form action="" method="post">
    <p>
      <label for="tipo_documento">Tipo Documento</label>
      <select id="tipo_documento" name="tipo_documento" required>
        <option value="1">DNI</option>
        <option value="2">Carnet de Extranjería</option>
        <option value="3">RUC</option>
      </select>
    </p>
    <p>
      <label for="numero_documento">Número de Documento</label>
      <input id="numero_documento" type="text" name="numero_documento" required>
    </p>
    <p>
      <label for="nombre_completo">Nombre Completo / Razón Social</label>
      <input id="nombre_completo" type="text" name="nombre_completo" required>
    </p>
    <p>
      <label for="direccion">Dirección</label>
      <input id="direccion" type="text" name="direccion" required>
    </p>
    <p>
      <label for="telefono">Teléfono</label>
      <input id="telefono" type="numbre" name="telefono" required>
    </p>
    <p>
      <label for="email">Email</label>
      <input id="email" type="email" name="email" required>
    </p>
    <p>
      <label for="fecha_nacimiento_creacion">Fecha de Nacimiento / Creación</label>
      <input id="fecha_nacimiento_creacion" type="date" name="fecha_nacimiento_creacion" required>
    </p>
    <p>
      <label for="estado">Estado</label>
      <select id="estado" name="estado" required>
        <option value="Activo">Activo</option>
        <option value="Inactivo">Inactivo</option>
      </select>
    </p>
    <input type="submit" value="Guardar">
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
