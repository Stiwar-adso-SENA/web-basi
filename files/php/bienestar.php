<?php
include 'conexionbd.php';

/if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y validar datos
    $capacitacion = isset($_POST['capacitacion']) ? 1 : 0;
    $info_capacitacion = mysqli_real_escape_string($conn, $_POST['info_capacitacion']);

    $recreacion = isset($_POST['recreacion']) ? 1 : 0;
    $info_recreacion = mysqli_real_escape_string($conn, $_POST['info_recreacion']);

    // Validar otros campos de la misma forma
    $fecha_hora = $_POST['fecha_hora']; // Asegúrate de que se envíe este dato correctamente.

    // Insertar en la base de datos
    $sql = "INSERT INTO programas_bienestar (capacitacion, info_capacitacion, recreacion, info_recreacion, fecha_hora_registro) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issis", $capacitacion, $info_capacitacion, $recreacion, $info_recreacion, $fecha_hora);

    if ($stmt->execute()) {
        echo "✅ Registro exitoso.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
