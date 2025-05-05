<?php
session_start();
include 'conexionbd.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Por favor ingrese todos los datos.'); window.location.href='../login.html';</script>";
        exit();
    }

    // Evita inyección SQL
    $username = mysqli_real_escape_string($conn, $username);
    
    // Consulta preparada
    $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = ? OR email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['nombre'] = $user_data['nombre']; // Asegúrate de que 'nombre' esté en la base de datos
            $_SESSION['role'] = $user_data['role'];


            // Redirige al panel de usuario
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location.href='../login.html';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location.href='../login.html';</script>";
    }
}
