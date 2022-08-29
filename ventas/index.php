<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists("productos.json")) { //si el archivo "datos.txt" existe
    $jsonProductos = file_get_contents("productos.json"); // En la variable $jsonStr Almaceno lo que hay en datos.txt
    $aProductos = json_decode($jsonProductos, associative: true); // Decodifico lo que hay en la variable $jsonStr y la asigno a $aDatos

} else {
    $aProductos = array();  //Si no existe arranco el array vacío.
}

if (file_exists("compra.json")) {
    $jsonCompra = file_get_contents("compra.json");
    $aCompras = json_decode($jsonCompra, associative: true);
} else {
    $aCompras = array();
}
$id = isset($_GET["id"]) && $_GET["id"] >= 0 ? $_GET["id"] : "";
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
        file_put_contents("productos.json", $jsonProductos);
    }
    if (isset($_POST["btnCompra"])) {
        $nombreProducto = trim($_POST["txtProducto"]);
        $cantidadProducto = $_POST["numCantidad"] == "" ? $_POST["numCantidad"] = 1 : trim($_POST["numCantidad"]);
        $productoNoExiste = 0;
        foreach ($aProductos as $producto) {
            
            if ($nombreProducto == $producto["nombre"]) {
                $productoNoExiste = 1;
                print_r($productoNoExiste);
                $nombre = $producto["nombre"];
                $codigo = $producto["codigo"];
                $stock = $producto["stock"];
                $precio = $producto["precio"] * $cantidadProducto;

                $aCompras[] = array(
                    "nombre" => $nombre,
                    "codigo" => $codigo,
                    "cantidad" => $cantidadProducto,
                    "stock" => $stock,
                    "precio" => $precio
                );
            
            
        
                $jsonCompra = json_encode($aCompras);
                file_put_contents("compra.json", $jsonCompra);
        
                $jsonNuevoProducto = file_get_contents("compra.json");
                $aCompras = json_decode($jsonNuevoProducto, associative: true);
            } 
        }
        print_r($productoNoExiste);
        
    }
}

if (isset($_GET["do"]) && $_GET["do"] == "eliminar") {
    unset($aCompras[$id]);
    $jsonNuevoProducto = json_encode($aCompras);
    file_put_contents("compra.json", $jsonNuevoProducto);
    header("Location: index.php");
}

function sumarTotal($aCompras)
{
    if ($aCompras != array()) {
        $valor = 0;
        foreach ($aCompras as $compra) {
            $valor = $valor + $compra["precio"];
        }
        return $valor;
    } else {
        $valor = 0;
        return $valor;
    }
}

if (isset($_POST["btnVuelto"])) {
    $pago = trim($_POST["numVuelto"]);
    $vuelto = $pago - sumarTotal($aCompras);
} else {
    $vuelto = 0;
}

if (isset($_REQUEST["btnCobrar"])) {
    foreach ($aProductos as $id => $producto) {
        
        foreach ($aCompras as $compra) {
            if ($producto["nombre"] == $compra["nombre"]) {
                unset($aProductos[$id]);
                $jsonProductos = json_encode($aProductos);
                file_put_contents("productos.json", $jsonProductos);
                $producto["stock"] = $producto["stock"] - $compra["cantidad"];
                array_push($aProductos, $producto);
                $jsonProductos = json_encode($aProductos);
                file_put_contents("productos.json", $jsonProductos);  
            }
        }
    }
    $aCompras = array();
    $jsonCompra = json_encode($aCompras);
    file_put_contents("compra.json", $jsonCompra);
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
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" style="color: #fff" href="index.php">Plataforma de Ventas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" style="color: #fff" aria-current="page" href="index.php"><i class="bi bi-shop-window" style="font-size: 20px;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #fff" href="stock.php">Mis Productos</a>
                        </li>
                    </ul>
                </div>
                <li class="nav-item dropdown my-auto" style="list-style: none;">
                    <a class="nav-link dropdown-toggle" style="color: #fff" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person" style="font-size: 20px;"></i>
                        Mi Cuenta
                    </a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Editar</a></li>
                        <li><a class="dropdown-item" href="login.php">Cerrar sesion</a></li>
                    </ul>
                </li>
            </div>
        </nav>
    </header>
    <main class="container-fluid">
        <div class="row">
            <div class="col-6">
                <form action="" method="post">
                    <div class="col-8">
                        <label for="txtProducto">Nombre del Producto</label>
                        <input type="text" name="txtProducto" class="form-control">
                    </div>
                    <div class="col-8">
                        <label for="numCantidad">Cantidad</label>
                        <input type="number" name="numCantidad" class="form-control">
                    </div>
                    <div class="col-12 my-2">
                        <button type="submit" name="btnCompra" class="btn btn-primary">Agregar a la Compra</button>
                    </div>
                </form>
                <?php if($productoNoExiste = 0){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo "El producto no existe"; ?>
                    </div>

                <?php } ?>
            </div>
            <div class="col-6">
                <div class="col-12">
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
                    <div class="col-12 py-3">
                        <h3 style="color: green;">Total: <?php echo "$" . number_format(sumarTotal($aCompras), 2, ".", ","); ?> </h3>
                        <h5>Su vuelto es: $<?php echo isset($vuelto) ? number_format($vuelto, 2, ".", ",") : ""; ?> </h5>
                        <form action="" method="post">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Vuelto
                        </button>
                        
                            <button type="submit" name="btnCobrar" class="btn btn-success">Cobrar</button>
                        </form>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Cobrar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h3 style="color: green;">Total: <?php echo "$" . number_format(sumarTotal($aCompras), 2, ".", ","); ?></h3>
                                        <form action="" method="post">
                                            <div class="col-12">
                                                <label for="numVuelto">¿Con cuánto paga?</label>
                                                <input type="number" name="numVuelto" class="form-control">
                                            </div>
                                            <button type="submit" name="btnVuelto" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary my-2">Vuelto</button>
                                        </form>
                                        
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
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
                            <th>En Stock</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Remover</th>
                        </thead>
                        <tbody>
                            <?php
                            if ($aCompras != array()) {
                                foreach ($aCompras as $id => $compra) {
                            ?>
                                    <tr>
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $compra["codigo"]; ?></td>
                                        <td><?php echo $compra["nombre"]; ?></td>
                                        <td style="<?php echo $compra["stock"] <= 10? "color: red;" : ""; ?>"><?php echo $compra["stock"] <= 10? "Stock Crítico" : $compra["stock"] ?></td>
                                        <td><?php echo $compra["cantidad"]; ?></td>
                                        <td><?php echo "$" . number_format($compra["precio"], 2, ".", ","); ?></td>
                                        <td><a href="index.php?id=<?php echo $id; ?>&do=eliminar"><i class="bi bi-trash3"></i></td>
                                    </tr>
                                <?php  } ?>
                            <?php } ?>
                            

                            
                        </tbody>
                    </table>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>