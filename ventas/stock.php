<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists("productos.txt")) {
    $jsonProductos = file_get_contents("productos.txt");
    $aProductos = json_decode($jsonProductos, true);
} else {
    $aProductos = array();
}

$id = isset($_GET["id"]) && $_GET["id"] >= 0 ? $_GET["id"] : "";


if($_POST){
    if(isset($_POST["btnNuevoProducto"])){
        $nombre = trim($_POST["txtEditarNuevoProducto"]);
        $codigo = trim($_POST["numEditarCodigo"]);
        $stock = trim($_POST["numEditarCantidad"]);
        $precio = trim($_POST["numEditarPrecio"]);

        $aProductos[$id] = array(
            "nombre" => $nombre,
            "codigo" => $codigo,
            "stock" => $stock,
            "precio" => $precio

        );
        $jsonProductos = json_encode($aProductos);
        file_put_contents("productos.txt", $jsonProductos);
    }
}

if(isset($_GET["do"]) && $_GET["do"] == "eliminar"){
    unset($aProductos[$id]);
    $jsonProductos = json_encode($aProductos);
    file_put_contents("productos.txt", $jsonProductos);
    header("Location: stock.php");
}





?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vemtas - Stock</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>

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
                            <label for="txtEditarNuevoProducto">Nombre</label>
                            <input type="text" name="txtEditarNuevoProducto" class="form-control" id="txtEditarNuevoProducto" value="<?php echo isset($aProductos[$id])? $aProductos[$id]["nombre"] : ""; ?>">
                        </div>
                        <div class="col-12 my-3">
                            <label for="numEditarCodigo">Código</label>
                            <input type="number" name="numEditarCodigo" id="" class="form-control" value="<?php echo isset($aProductos[$id])? $aProductos[$id]["codigo"] : ""; ?>">
                        </div>
                        <div class="col-12 my-3">
                            <label for="numEditarCantidad">Stock</label>
                            <input type="number" name="numEditarCantidad" id="" class="form-control" value="<?php echo isset($aProductos[$id])? $aProductos[$id]["stock"] : ""; ?>">
                        </div>
                        <div class="col-12 my-3">
                            <label for="numEditarPrecio">Precio</label>
                            <input type="number" name="numEditarPrecio" id="" class="form-control" value="<?php echo isset($aProductos[$id])? $aProductos[$id]["precio"] : ""; ?>">
                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" name="btnNuevoProducto">Editar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
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
            <div class="col-12 my-3">
                <h1>Stock de Productos</h1>
            </div>
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary" id="editar">Editar</button>
        </div>
        <div class="row">
            <table class="table table-hover border">
                <thead>
                    <th>#</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($aProductos as $id => $producto) {
                    ?>
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $producto["codigo"]; ?></td>
                            <td><?php echo $producto["nombre"]; ?></td>
                            <td><?php echo $producto["stock"]; ?></td>
                            <td><?php echo "$" . $producto["precio"]; ?></td>
                            <td><a href="?id=<?php echo $id ?>&do=editar" id="elegir">Elegir</a></td>
                            <td><a href="stock.php?id=<?php echo $id ?>&do=eliminar"><i class="bi bi-trash3"></i></a></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>

</html>