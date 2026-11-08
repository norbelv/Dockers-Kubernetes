<?php
$host = 'db'; // Nombre del servicio en docker-compose
$user = 'usuario_app';
$pass = 'password_app';
$db   = 'mi_base_datos';

$conn = new mysqli($host, $user, $pass, $db);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .box { background: white; padding: 20px; border-radius: 8px; width: 400px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        input[type="text"] { width: 93%; padding: 8px; margin: 8px 0; }
        input[type="submit"] { background: #28a745; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>

    <div class="box">
        <h2>Registrar Persona</h2>
        <form action="guardar.php" method="POST">
            <label>Nombre:</label><br>
            <input type="text" name="nombre" required><br>
            <label>Apellido:</label><br>
            <input type="text" name="apellido" required><br><br>
            <input type="submit" value="Guardar en MySQL">
        </form>
    </div>

    <div class="box" style="width: 500px;">
        <h2>Usuarios Registrados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
            <?php
            if (!$conn->connect_error) {
                $resultado = $conn->query("SELECT * FROM usuarios ORDER BY id DESC");
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['apellido']}</td>
                          </tr>";
                }
            }
            ?>
        </table>
    </div>

</body>
</html>