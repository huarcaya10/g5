<?php
$hostDB = '127.0.0.1';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenaDB = '';

$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8";

try {

  $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

  $miPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $miconsulta = $miPDO->prepare('SELECT * FROM Clientes;');

  $miconsulta->execute();
} catch(PDOException $e) {
  
  echo "Error: " . $e->getMessage();
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar - CRUD PHP</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    table td, table th {
      border: 1px solid orange;
      text-align: center;
      padding: 1.3rem;
    }
    .button {
      border-radius: 0.5rem;
      color: white;
      background-color: orange;
      padding: 1rem;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <p><a class="button" href="nuevo.php">Crear Cliente</a></p>
  <table>
    <tr>
      <th>ID</th>
      <th>Tipo Documento</th>
      <th>Número de Documento</th>
      <th>Nombre Completo / Razón Social</th>
      <th>Dirección</th>
      <th>Teléfono</th>
      <th>Email</th>
      <th>Fecha de Nacimiento / Creación</th>
      <th>Estado</th>
      <td></td>
      <td></td>
    </tr>
    <?php foreach ($miconsulta as $clave => $valor) : ?>
      <tr>
        <td><?= $valor['id']; ?></td>
        <td>
            <?php
            switch ($valor['tipo_documento_id']) {
                case 1:
                    echo 'DNI';
                    break;
                case 2:
                    echo 'Carnet de Extranjería';
                    break;
                case 3:
                    echo 'RUC';
                    break;
                default:
                    echo 'Tipo de documento no especificado';
                    break;
            }
            ?>
        </td>

        <td><?= $valor['numero_documento']; ?></td>
        <td><?= $valor['nombre_completo_razon_social']; ?></td>
        <td><?= $valor['direccion']; ?></td>
        <td><?= $valor['telefono']; ?></td>
        <td><?= $valor['email']; ?></td>
        <td><?= $valor['fecha_nacimiento_creacion']; ?></td>
        <td><?= $valor['estado']; ?></td>
        <td><a class="button" href="modificar.php?id=<?= $valor['id']; ?>">Modificar</a></td>
        <td><a class="button" href="borrar.php?id=<?= $valor['id']; ?>">Borrar</a></td>
      </tr>
    <?php endforeach; ?>
  </table><br>
  <a class="button" href="tabla.php">Reporte 1</a>
  <a class="button" href="ReporteAutor.php">Reporte Autor</a>
</body>
</html>
