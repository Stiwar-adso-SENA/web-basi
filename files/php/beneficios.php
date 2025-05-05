<?php
include 'conexionbd.php'; // Asegúrate de que este archivo conecta correctamente con tu BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compensaciones = $_POST['compensaciones'];
    $salario = $_POST['salario'];
    $seguridad_social = $_POST['seguridad_social'];
    $caja_compensacion = $_POST['caja_compensacion'];
    $puesto_trabajo = $_POST['puesto_trabajo'];
    $crecimiento_personal = $_POST['crecimiento_personal'];

    $sql = "INSERT INTO compensaciones_beneficios (
                compensaciones, salario, seguridad_social, caja_compensacion, 
                puesto_trabajo, crecimiento_personal
            ) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param_
