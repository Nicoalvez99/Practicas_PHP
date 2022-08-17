<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists("productos.txt")) { //si el archivo "datos.txt" existe
    $jsonProductos = file_get_contents("productos.txt"); // En la variable $jsonStr Almaceno lo que hay en datos.txt
    $aProductos = json_decode($jsonProductos, true); // Decodifico lo que hay en la variable $jsonStr y la asigno a $aDatos

} else {
    $aProductos = array();  //Si no existe arranco el array vacío.
}


if(file_exists("compra.txt")){
    $jsonCompra = file_get_contents("compra.txt");
    $aCompras = json_decode($jsonCompra, true);
    print_r($aCompras);
} else {
    $aCompras = array();
}

if ($_POST) {

    if (isset($_POST["btnNuevoProducto"])) {
        $nombre = trim($_POST["txtNombreNuevoProducto"]);
        $codigo = trim($_POST["numCodigo"]);
        $stock = trim($_POST["numNuevoCantidad"]);
        $precio = trim($_POST["numNuevoPrecio"]);



        $aProductos[] = array(
            "nombre" => $nombre,
            "codigo" => $codigo,
            "stock" => $stock,
            "precio" => $precio
        );


        $jsonProductos = json_encode($aProductos);
        file_put_contents("productos.txt", $jsonProductos);
    }
    if (isset($_POST["btnCompra"])) {
        $nombreProducto = trim($_POST["txtProducto"]);
        $cantidadProducto = $_POST["numCantidad"] == ""? $_POST["numCantidad"] = 1 : trim($_POST["numCantidad"]);

        foreach($aProductos as $producto){
            if($nombreProducto == $producto["nombre"]){
                $aCompras = array("nombre" => $producto["nombre"], 
                            "codigo" => $producto["codigo"], 
                            "stock" => $producto["stock"], 
                            "precio" => $producto["precio"]
                        );

                print_r($aCompras);
                
            }
        }
        

        
        $jsonCompra = json_encode($aCompras);
        file_put_contents("compra.txt", $jsonCompra, FILE_APPEND);
        

        $jsonCompra = file_get_contents("compra.txt");
        $aCompras = json_decode($jsonCompra, associative: true);

        

        

    } 

}






?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <header class="container-fluid mb-3">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Sistema Ventas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link" href="stock.php">Stock</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
        <div class="row">
            <div class="col-6">
                <form action="" method="post">
                    <div class="col-12">
                        <div class="col-4">
                            <label for="txtProducto">Nombre del Producto</label>
                            <input type="text" name="txtProducto" class="form-control">
                        </div>
                        <div class="col-4">
                            <label for="numCantidad">Cantidad</label>
                            <input type="number" name="numCantidad" class="form-control">
                        </div>
                        <div class="col-4">
                            <button type="submit" name="btnCompra" class="btn btn-primary">Agregar a la Compra</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    + Agregar nuevo producto
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Producto Nuevo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <div class="col-12 my-3">
                                        <label for="txtNombreNuevoProducto">Nombre</label>
                                        <input type="text" name="txtNombreNuevoProducto" class="form-control" required>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label for="numCodigo">Código</label>
                                        <input type="number" name="numCodigo" id="" class="form-control" required>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label for="numNuevoCantidad">Stock</label>
                                        <input type="number" name="numNuevoCantidad" id="" class="form-control" required>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label for="numNuevoPrecio">Precio</label>
                                        <input type="number" name="numNuevoPrecio" id="" class="form-control" required>
                                    </div>

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" name="btnNuevoProducto">+ Agregar</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Remover</th>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($_POST["btnCompra"])){
                                //foreach($aCompras as $compra){ ?>
                                    <tr>
                                        <td><?php //echo $id; ?></td>
                                        <td><?php echo $aCompras["codigo"]; ?></td>
                                        <td><?php echo $aCompras["nombre"]; ?></td>
                                        <td><?php echo $cantidadProducto; ?></td>
                                        <td><?php echo $aCompras["precio"] * $cantidadProducto; ?></td>
                                        <td><a href=""><i class="bi bi-trash3"></i></td>
                                    </tr>      
                            <?php  } ?>
                        <?php //} ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>