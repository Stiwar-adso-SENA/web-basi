<?php
include 'conexion.php'; // Asegúrate de que este archivo existe y se conecta bien

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['message']);

    if (empty($nombre) || empty($email) || empty($mensaje)) {
        echo "<script>alert('Por favor, completa todos los campos del formulario.'); window.location.href='../contacto.html';</script>";
        exit();
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO mensajes_contacto (nombre, email, mensaje, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $mensaje);

    if ($stmt->execute()) {
        echo "<h2>✅ ¡Gracias por contactarnos, $nombre!</h2>";
        echo "<p>Te responderemos pronto al correo: $email.</p>";
        echo "<a href='contacto.html'>Volver al formulario</a>";
    } else {
        echo "❌ Error al enviar el mensaje: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

