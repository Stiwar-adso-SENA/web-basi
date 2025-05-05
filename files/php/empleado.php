<?php
include 'conexionbd.php';

if (isset($_POST['firstName'], $_POST['lastName'], $_POST['address'], $_POST['phone'], $_POST['position'])) {
    $nombre = trim($_POST['firstName']);
    $apellido = trim($_POST['lastName']);
    $direccion = trim($_POST['address']);
    $telefono = trim($_POST['phone']);
    $cargo = trim($_POST['position']);

    // Validación rápida (puedes hacerla más completa si quieres)
    if (empty($nombre) || empty($apellido) || empty($direccion) || empty($telefono) || empty($cargo)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.location.href='../registro.html';</script>";
        exit();
    }

    $sql = "INSERT INTO empleados (nombre, apellido, direccion, telefono, cargo)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $direccion, $telefono, $cargo);

    if ($stmt->execute()) {
        echo "<script>alert('Empleado registrado exitosamente.'); window.location.href='../index.html';</script>";
    } else {
        echo "<script>alert('Error al registrar al empleado.'); window.location.href='../registro.html';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Faltan datos del formulario.'); window.location.href='../registro.html';</script>";
}

$conn->close();
?>
