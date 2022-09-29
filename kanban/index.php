<?php
include_once "config.php";
include_once "entidades/proyecto.php";
include_once "entidades/tarea.php";
include_once "entidades/usuario.php";





?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


</head>

<body id="body">

    <main class="container-fluid">
        <div class="row">
            <div class="col-3 px-0">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark largo mr-0" id="barraNav" style="width: 300px;">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi pe-none me-2" width="40" height="32">
                            <use xlink:href="#bootstrap" />
                        </svg>
                        <span class="fs-4">Kanban</span>
                    </a>
                    <hr>
                    <p style="color: #bbb; font-size: 15px;">Todos los proyectos (<?php //echo count($aProyectos); ?>)</p>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <?php /*if ($aProyectos != "") {
                            foreach ($aProyectos as $id => $proyecto) { ?>
                                <li class="nav-item my-2">
                                    <a href="index.php?id=<?php echo $id; ?>" class="nav-link active" aria-current="page">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#home" />
                                        </svg>
                                        <?php echo $id; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php }*/ ?>

                        <a href="#" class="btn my-5" style="color: #ccc;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            + Agregar Proyecto
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background-color: #20202c;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Proyecto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <div class="col-12 my-3">
                                                <label for="txtNombreProyecto">Nombre: </label>
                                                <input type="text" name="txtNombreProyecto" id="" class="form-control" style="background-color: #20202c; color: #ccc;">
                                            </div>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="btnProyecto" class="btn btn-primary">Agregar</button>
                                        </form>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </ul>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="btn-group">
                                <button type="button" id="btnSol" class="btn btn-outline-secondary"><i class="bi bi-brightness-high"></i></button>
                                <button type="button" id="btnLuna" class="btn btn-outline-secondary"><i class="bi bi-moon"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9 mx-0 cuerpo" id="cuerpo">
                <div class="row">
                    <div class="col 12 py-4 d-flex tarea" id="tarea">
                        <div class="col-4">
                            <h4 style="color: #fff;">Titulo de la tarea</h4>
                        </div>
                        <div class="col-4 offset-4">
                            <button type="button" class="btn btn-primary flex-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                + Agregar nueva tarea
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="background-color: #20202c;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel" style="color: #ccc;">Nueva Tarea</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ccc;"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                <div class="col-12 my-4">
                                                    <label for="txtTitulo" style="color: #ccc;">Titulo</label>
                                                    <input type="text" name="txtTitulo" id="" class="form-control" style="background-color: #20202c; color: #ccc;" placeholder='Ej: "Tomar café"'>
                                                </div>
                                                <div class="col-12 my-4">
                                                    <label for="txtDescripcion" style="color: #ccc;">Descripción</label>
                                                    <textarea name="txtDescripcion" id="" cols="60" rows="5" style="background-color: #20202c; color: #ccc;" placeholder='Ej: "Poner café en la taza y agua a calentar."'></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label for="txtSubTarea" style="color: #ccc;">Agregar subtarea</label>
                                                    <input type="text" name="txtSubTareaUno" id="" class="form-control" style="background-color: #20202c; color: #ccc;">
                                                    <input type="text" name="txtSubTareaDos" id="" class="form-control my-2" style="background-color: #20202c; color: #ccc;">
                                                </div>
                                                <div class="col-12 my-2">
                                                    <label for="optSelect" style="color: #ccc;">Status</label>
                                                    <select name="optSelect" id="" class="form-control" style="background-color: #20202c; color: #ccc;">
                                                        <option value="Por Hacer" style="color: #ccc;">Por Hacer</option>
                                                        <option value="Haciendo" style="color: #ccc;">Haciendo</option>
                                                        <option value="Terminado" style="color: #ccc;">Terminado</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="btnTarea" class="btn btn-primary">Agregar</button>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <?php //if (isset($id) && $id != "") { ?>
                        <?php //foreach($aProyectos[$id] as $tareas){ ?>
                        <div class="col-4">
                            <p style="color: #bbb">Por hacer (0)</p>
                            <?php // print_r($aProductos[$id]); ?>
                        </div>
                        <div class="col-4">
                            <p style="color: #bbb;">Haciendo (0)</p>
                           <?php // if($tareas["estado"] = "Haciendo"){ ?>
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php //echo $tareas["nombre"]; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?php //echo $tareas["estado"]; ?></h6>
                                    <p class="card-text"><?php //echo $tareas["descripcion"]; ?></p>
                                    <a href="#" class="card-link">Ediar</a>
                                    <a href="#" class="card-link">Eliminar tarea</a>
                                </div>
                            </div>
                            <?php // } ?>
                        </div>
                        <div class="col-4">
                            <p style="color: #bbb;">Terminado (0)</p>
                        </div>
                        <?php //} ?>
                    <?php //} ?>
                    <?php //if($id == ""){ ?>
                        <p>No hay tareas disposibles, cree un proyecto o seleccione uno.</p>
                    <?php //} ?>
                </div>
            </div>
        </div>
    </main>

    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>