<?php
include 'conexionbd.php';

$sql = "SELECT id, nombre, apellido, direccion, telefono, cargo FROM empleados";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Cargo</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['apellido'] . "</td>
                <td>" . $row['direccion'] . "</td>
                <td>" . $row['telefono'] . "</td>
                <td>" . $row['cargo'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay empleados registrados.";
}

$conn->close();
?>
