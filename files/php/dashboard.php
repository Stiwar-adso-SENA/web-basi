<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirige al login
    header("Location: login.php");
    exit();
}

include 'conexionbd.php'; // Conexión a la base de datos

// Obtener los datos del usuario desde la sesión
$user_id = $_SESSION['user_id'];
$usuario = $_SESSION['usuario'];

// Verificar si 'nombre' está presente en la sesión
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario no registrado';

// Obtener más detalles del usuario desde la base de datos
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }
        h1 {
            color: #4CAF50;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-info {
            margin-bottom: 20px;
        }
        a {
            color: #ff5733;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h1>
        
        <div class="profile-info">
            <p><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            <p><strong>Edad:</strong> <?php echo htmlspecialchars($user_data['edad']); ?></p>
            <p><strong>Rol:</strong> <?php echo htmlspecialchars($user_data['role']); ?></p>
            <p><strong>Foto:</strong> 
                <?php if ($user_data['foto']) { ?>
                    <img src="<?php echo htmlspecialchars($user_data['foto']); ?>" alt="Foto de perfil" width="100">
                <?php } else { ?>
                    No hay foto de perfil.
                <?php } ?>
            </p>
        </div>

        <a href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>
