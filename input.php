<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(file_exists("datos.txt")){ //si el archivo "datos.txt" existe
    $jsonStr = file_get_contents("datos.txt"); // En la variable $jsonStr Almaceno lo que hay en datos.txt
    $aDatos = json_decode($jsonStr, true); // Decodifico lo que hay en la variable $jsonStr y la asigno a $aDatos
    
} else{
    $aDatos = array();  //Si no existe arranco el array vacío.
}

$id = isset($_GET["id"]) && $_GET["id"] >= 0 ? $_GET["id"] : "";

if($_POST){
    $nombre = $_POST["txtNombre"];
    $pais = $_POST["lstNacion"];

    if($id >= 0){
        $aDatos[$id] = array("nombre" => $nombre, "pais" => $pais);
    } else{
        $aDatos[] = array("nombre" => $nombre, "pais" => $pais);
    }

    $jsonStr = json_encode($aDatos);
    file_put_contents("datos.txt", $jsonStr);
}

if(isset($_GET["do"]) && $_GET["do"] == "eliminar"){
    unset($aDatos[$id]);
    $jsonStr = json_encode($aDatos);
    file_put_contents("datos.txt", $jsonStr);
    header("Location: input.php");
    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1>Practica con Input</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="" method="post">
                    <div class="col-12 my-3">
                        <label for="txtNombre">Nombre*</label>
                        <input type="text" name="txtNombre" required class="form-control" value="<?php echo isset($aDatos[$id])? $aDatos[$id]["nombre"] : ""; ?>">
                    </div>
                    <div class="col-12">
                        <label for="lstNacion">Nación*</label>
                        <select name="lstNacion" id="lstNacion" class="form-control">
                            <option value="Seleccionar" disabled selected>Seleccionar</option>
                            <option value="Argentina" <?php echo isset($aDatos[$id]) && $aDatos[$id]["pais"] == "Argentina"? "selected" : ""; ?>>Argentina</option>
                            <option value="Chile" <?php echo isset($aDatos[$id]) && $aDatos[$id]["pais"] == "Chile"? "selected" : ""; ?>>Chile</option>
                            <option value="Peru" <?php echo isset($aDatos[$id]) && $aDatos[$id]["pais"] == "Perú"? "selected" : ""; ?>>Perú</option>
                            <option value="Colombia" <?php echo isset($aDatos[$id]) && $aDatos[$id]["pais"] == "Colombia"? "selected" : ""; ?>>Colombia</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary my-3">Guardar</button>
                </form>
            </div>
            <div class="col-6">
                <table class="table table-hover">
                    <thead>
                        <th>Nombre</th>
                        <th>País</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php foreach($aDatos as $id => $dato){  ?>
                        <tr>
                            <td><?php echo $dato["nombre"]; ?></td>
                            <td><?php  echo $dato["pais"]; ?></td>
                            <td><a href="input.php?id=<?php echo $id; ?>&do=editar"><i class="bi bi-pencil"></i></a></td>
                            <td><a href="input.php?id=<?php echo $id; ?>&do=eliminar"><i class="bi bi-trash3"></i></a></td>
                        </tr>
                            <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>