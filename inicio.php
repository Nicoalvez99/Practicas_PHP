<?php
$nombre = "";
$apellido = "";
$edad = "";
$mail = "";
$contraseña = "";
if($_POST){
    $nombre = $_POST["txtNombre"];
    $apellido = $_POST["txtApellido"];
    $edad = $_POST["txtEdad"];
    $mail = $_POST["txtEmail"];
    $contraseña = $_POST["txtContraseña"];
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <?php 
        echo "Tu nombre es: " . $nombre . "<br>";
        echo "Tu apellido es: " . $apellido . "<br>";
        echo "Tu edad es de: " . $edad . "<br>";
        echo "Tu Email es: " . $mail . "<br>";
        echo "Tu contraseña es: " . $contraseña . "<br>";
    
    ?>
    <a href="index.php">Salir</a>
</body>
</html>