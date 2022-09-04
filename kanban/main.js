let navBar = document.getElementById('barraNav');
let cuerpo = document.querySelector('largo');
let btnSol = document.getElementById('btnSol');
let btnLuna = document.getElementById('btnLuna');
let body = document.getElementById('body');
let tarea = document.getElementById('tarea');

btnSol.addEventListener("click", ()=>{
    navBar.classList.add('luz');
    cuerpo.classList.add('luz');
    body.classList.add('luz');
    tarea.classList.add('luz');
});

btnLuna.addEventListener("click", ()=> {
    navBar.classList.remove('luz');
    cuerpo.classList.remove('luz');
    body.classList.remove('luz');
    tarea.classList.remove('luz');
});