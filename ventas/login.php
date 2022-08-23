<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if($_POST){
    $nombre = $_POST["txtNombre"];
    $contraseña = $_POST["txtContraseña"];

    if($nombre == "Nicolas" && $contraseña == "admin123"){
        header("Location: index.php");
    } else {
        $error = "";
    }
}








?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body id="body" style="background-color: blue;">
    <main class="container-fluid">
        <div class="row">
            <div class=" col-6 mt-5">
                <div class="col-12 offset-10">
                    <div class="card shadow" style="width: 18rem;">
                        <img src="imagenes/login.png" class="card-img-top">
                        <div class="card-body">
                            <h2 class="card-title text-center">¡Log In!</h2>
                            <form action="" method="post">
                                <?php if(isset($error)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        Usuario o contraseña incorrectas.
                                    </div>
                                <?php endif; ?>
                                <div class="col-12 my-2">
                                    <label for="txtnombre">Nombre:</label>
                                    <input type="text" name="txtNombre" class="form-control" required>
                                </div>
                                <div class="col-12 my-2">
                                    <label for="txtContraseña">Contraseña:</label>
                                    <input type="password" name="txtContraseña" class="form-control" id="" required>
                                </div>
                                <div class="col-12 my-2">
                                    <button type="submit" name="btnEntrar" class="btn btn-primary">Entrar</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>