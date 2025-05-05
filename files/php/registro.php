<?php
include 'conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $primer_apellido = htmlspecialchars($_POST['primer_apellido']);
    $segundo_apellido = isset($_POST['segundo_apellido']) ? htmlspecialchars($_POST['segundo_apellido']) : NULL;
    $email = htmlspecialchars($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $edad = intval($_POST['edad']); // Asegúrate de convertirlo a un número entero
    $cedula = htmlspecialchars($_POST['cedula']);
    $usuario = htmlspecialchars($_POST['usuario']); // Obtén el nombre de usuario

    // Foto
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : NULL;
    $fotoTemp = isset($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : NULL;
    $rutaDestino = $foto ? 'uploads/' . basename($foto) : NULL;

    // Verificación de los campos obligatorios
    if (!empty($nombre) && !empty($primer_apellido) && !empty($email) && !empty($pass) && !empty($edad) && !empty($cedula) && !empty($usuario)) {
        
        // Si se sube una foto, mueve el archivo
        if ($foto && $fotoTemp) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true); // Crea la carpeta si no existe
            }

            if (!move_uploaded_file($fotoTemp, $rutaDestino)) {
                echo "<script>alert('Error al subir la foto.'); window.location.href='../registro.html';</script>";
                exit();
            }
        } else {
            $rutaDestino = NULL; // Si no hay foto, asigna NULL
        }

        // Inserta el usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, primer_apellido, segundo_apellido, email, password, foto, edad, cedula, usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        // Usar "ssssisis" para especificar los tipos de las variables
        $stmt->bind_param("ssssssiss", $nombre, $primer_apellido, $segundo_apellido, $email, $pass, $rutaDestino, $edad, $cedula, $usuario);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso. ¡Ahora puedes iniciar sesión!'); window.location.href='./index.html';</script>";
        } else {
            echo "<script>alert('Error al registrar el usuario.'); window.location.href='../registro.html';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Faltan datos obligatorios del formulario.'); window.location.href='../registro.html';</script>";
    }

    $conn->close();
}
?>
