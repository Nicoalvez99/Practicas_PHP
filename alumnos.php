<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Persona{
    protected $nombre;
    protected $edad;
    protected $dni;
    protected $correo;
    protected $telefono;

    public function __construct($nombre, $edad, $dni, $correo, $telefono)
    {
        $this -> nombre = $nombre;
        $this -> edad = $edad;
        $this -> dni = $dni;
        $this -> correo = $correo;
        $this -> telefono = $telefono;
    }
    public function __get($propiedad)
    {
        return $this -> $propiedad;
    }
    public function __set($propiedad, $valor)
    {
        $this -> $propiedad = $valor; 
    }
}

class Alumno extends Persona{
    private $aClases;

    public function __construct($nombre, $edad, $dni, $correo, $telefono)
    {
        parent::__construct($nombre, $edad, $dni, $correo, $telefono);
        $this -> aClases = array();
    }
    public function __get($propiedad)
    {
        return $this -> $propiedad;
    }
    public function __set($propiedad, $valor){
        $this -> $propiedad = $valor;
    }
    public function imprimir(){
        echo "<h5>Nombre y Apellido: " . $this -> nombre . "</h5><br>";
        echo "<h5>Edad: " . $this -> edad . "</h5><br>";
        echo "<h5>Dni: " . $this -> dni . "</h5><br>";
        echo "<h5>Correo: " . $this -> correo . "</h5><br>";
        echo "<h5>Tel: " . $this -> telefono . "</h5><br>";
    }
}

if($_POST){
    $nombre = $_POST["txtNombre"];
    $edad = $_POST["numEdad"];
    $dni = $_POST["numDni"];
    $correo = $_POST["txtCorreo"];
    $telefono = $_POST["numTelefono"];

    $alumno1 = new Alumno ($nombre, $edad, $dni, $correo, $telefono);
}









?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>
<body>
    <main class="container-fluid">
        <div class="row">
            <div style="border-radius: 10px;" class="col-6 shadow my-5">
                <form action="" method="post">
                    <div class="col-12 my-3">
                        <label for="txtNombre">Nombre y Apellido</label>
                        <input type="text" name="txtNombre" class="form-control">
                    </div>
                    <div class="col-12 my-3">
                        <label for="txtEdad">Edad</label>
                        <input type="number" name="numEdad" class="form-control">
                    </div>
                    <div class="col-12 my-3">
                        <label for="numDni">Dni</label>
                        <input type="number" name="numDni" class="form-control">
                    </div>
                    <div class="col-12 my-3">
                        <label for="txtCorreo">Correo</label>
                        <input type="email" name="txtCorreo" class="form-control">
                    </div>
                    <div class="col-12 my-3">
                        <label for="numTelefono">Telefono</label>
                        <input type="tel" name="numTelefono" class="form-control">
                    </div>
                    <button type="submit" name="btnEnviar" class="btn btn-primary my-3">Enviar</button>
                </form>
            </div>
            <div class="col-6 my-5">
                <h5 class="text-center">Alumno</h5>
                <?php if(isset($_POST["btnEnviar"])){ ?>
                <p><?php $alumno1 -> imprimir(); ?></p>
                <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>