<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="estilos.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1>¡Registrate!</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mx-auto shadow p-3 sesion">
                <form action="inicio.php" method="post">
                    <div class="col-12">
                        <label for="txtNombre">Nombre:</label>
                        <input type="text" name="txtNombre" id="" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="txtApellido">Apellido:</label>
                        <input type="text" name="txtApellido" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="txtEdad">Edad:</label>
                        <input type="number" name="txtEdad" id="" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="txtEmail">Email:</label>
                        <input type="email" name="txtEmail" id="" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="txtContraseña">Contraseña:</label>
                        <input type="password" name="txtContraseña" id="" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary my-2">Ingresar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>