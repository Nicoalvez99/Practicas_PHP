<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("sesion.php");

if (file_exists("productos.json")) {
    $jsonProductos = file_get_contents("productos.json");
    $aProductos = json_decode($jsonProductos, associative: true);
} else {
    $aProductos = array();
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

            if ($nombreProducto == $producto["nombre"] || $nombreProducto == $producto["codigo"]) {
                $nombre = $producto["nombre"];
                $codigo = $producto["codigo"];
                $stock = $producto["stock"];
                $precioUnitario = $producto["precio"];
                $precio = $producto["precio"] * $cantidadProducto;

                $aCompras[] = array(
                    "nombre" => $nombre,
                    "codigo" => $codigo,
                    "cantidad" => $cantidadProducto,
                    "stock" => $stock,
                    "preciounitario" => $precioUnitario,
                    "precio" => $precio
                );
                $productoNoExiste = $productoNoExiste - 1;
                $jsonCompra = json_encode($aCompras);
                file_put_contents("compra.json", $jsonCompra);

                $jsonNuevoProducto = file_get_contents("compra.json");
                $aCompras = json_decode($jsonNuevoProducto, associative: true);
            } else {
                $productoNoExiste = $productoNoExiste + 1;
            }
        }
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

if(isset($_POST["btnDescuento"])){
    $valorDesc = $_POST["txtDescuento"];

    $valorAnterior = sumarTotal($aCompras) * $valorDesc / 100;
    $valorActual = sumarTotal($aCompras) - $valorAnterior;
    
} else{
    $valorActual = 0;
}


if (isset($_POST["btnVuelto"])) {
    $pago = trim($_POST["numVuelto"]);
    
    $vuelto = $pago - sumarTotal($aCompras);
    
} else {
    $vuelto = 0;
}
$totalProductos = count($aProductos);

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
if(isset($_POST["btnCerrarSesion"])){
    session_destroy();
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventus</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <header class="container-fluid mb-3">
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" style="color: #fff" href="index.php">Plataforma Ventas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" style="color: #fff" aria-current="page" href="index.php"><i class="bi bi-shop-window" style="font-size: 20px;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #fff" href="stock.php">Mis Productos <span class="badge text-bg-info"><?php echo $totalProductos; ?></span></a>
                        </li>
                    </ul>
                </div>
                <li class="nav-item dropdown my-auto" style="list-style: none;">
                    <a class="nav-link dropdown-toggle" style="color: #fff" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person" style="font-size: 20px;"></i>
                        Mi Cuenta
                    </a>
                    <ul class="dropdown-menu">
                        <form action="" method="post">
                            <li><a class="dropdown-item" href="#"><button name="btnCerrarSesion" class="btn btn-primary">Cerrar sesion</button></a></li>
                        </form>
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
                        <label for="txtProducto">Nombre o código del Producto</label>
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
                <?php if (isset($productoNoExiste) && $productoNoExiste == $totalProductos) { ?>
                    <div class="alert alert-danger" role="alert">
                        Este producto no existe en el stock.
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
                        <h3 style="color: green;">Total: <?php echo "$" . number_format(isset($_POST["btnDescuento"]) ? $valorActual : sumarTotal($aCompras), 2, ".", ","); ?> </h3>
                        <h5>Su vuelto es: $<?php echo isset($vuelto) ? number_format($vuelto, 2, ".", ",") : ""; ?> </h5>
                        
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Descuento</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Descuento en %:</label>
                                                <input type="number" class="form-control" id="recipient-name" name="txtDescuento">
                                            </div>
                                            <button type="submit" class="btn btn-danger" name="btnDescuento">Aplicar</button>
                                        </form>
                                    </div>
                                        
                                    
                                </div>
                            </div>
                        </div>
                        <form action="" method="post">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@mdo">Desc.</button>
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
                                        <h3 style="color: green;">Total: <?php echo "$" . number_format(isset($_POST["btnDescuento"]) ? $valorActual : sumarTotal($aCompras), 2, ".", ","); ?></h3>
                                        <form action="" method="post">
                                            <div class="col-12">
                                                <label for="numVuelto">¿Con cuánto paga?</label>
                                                <input type="number" name="numVuelto" class="form-control" required>
                                            </div>
                                            <button type="submit" name="btnVuelto" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary my-2">Vuelto</button>
                                        </form>
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
                            <th>Código</th>
                            <th>Producto</th>
                            <th>En Stock</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Precio total</th>
                            <th>Remover</th>
                        </thead>
                        <tbody>
                            <?php
                            if ($aCompras != array()) {
                                foreach ($aCompras as $id => $compra) {
                            ?>
                                    <tr>
                                        <td><?php echo $compra["codigo"]; ?></td>
                                        <td><?php echo $compra["nombre"]; ?></td>
                                        <td style="<?php echo $compra["stock"] <= 10 ? "color: red;" : ""; ?>"><?php echo $compra["stock"] <= 10 ? "Stock Crítico" : $compra["stock"] ?></td>
                                        <td><?php echo $compra["cantidad"]; ?></td>
                                        <td><?php echo "$" . number_format($compra["preciounitario"], 2, ".", ","); ?></td>
                                        <td><?php echo "$" . number_format($compra["precio"], 2, ".", ","); ?></td>
                                        <td><a href="index.php?id=<?php echo $id; ?>&do=eliminar"><i class="bi bi-trash3"></i></td>
                                    </tr>
                                <?php  } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if ($aCompras == array()) { ?>
                        <div class="alert alert-info text-center" role="alert">
                            Aún no hay productos en compra.
                        </div>
                    <?php } ?>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>