let editar = document.getElementById('txtEditarNuevoProducto').value;
let botonEditar = document.getElementById('editar');

if(editar != ""){
    botonEditar.classList.remove('btn-secondary');
    botonEditar.classList.add('btn-primary');
}