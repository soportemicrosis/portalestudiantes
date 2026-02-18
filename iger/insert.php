<?php

$host = "localhost";
$user = "smarrbcm_dbadmin";
$pass = "Admin2026.";
$db   = "smarrbcm_dbstudents";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  header("Location: index.html?status=db_error");
  exit();
}

// Datos
$nombres   = trim($_POST["nombres"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$grado     = trim($_POST["grado"] ?? "");
$curso     = trim($_POST["curso"] ?? "");
$semana    = intval($_POST["semana"] ?? 0);

// Archivo (solo nombre)
if (!isset($_FILES["archivo"])) {
  header("Location: index.html?status=no_file");
  exit();
}

$archivoNombre = basename($_FILES["archivo"]["name"]);

// Insert
$sql = "INSERT INTO entregas 
        (nombres, apellidos, grado, curso, semana, archivo_nombre, entregado)
        VALUES (?, ?, ?, ?, ?, ?, 1)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssis",
  $nombres,
  $apellidos,
  $grado,
  $curso,
  $semana,
  $archivoNombre
);

if ($stmt->execute()) {
  header("Location: index.html?status=ok");
} else {
  header("Location: index.html?status=error");
}

$conn->close();
exit();
?>
