import * as home from "./main.js";
import * as api from "./api_main.js";

const formularioHome = document.getElementById("formulario_home");
const mensaje = formularioHome.mensaje;
const imagen = formularioHome.imagen;
const hometimeLine = document.getElementById("home_timeline");
let arrayContenedores = [];

formularioHome.addEventListener("submit", enviarFormularioHome);

function enviarFormularioHome(e) {
  e.preventDefault();
  comprobarEnvioFormularioHome();
}

function comprobarEnvioFormularioHome() {
  if (mensaje.value === "" && imagen.value === "") {
    alert(
      "Para crear un post, tienes que escribir un mensaje o subir una imagen o realizar ambas"
    );
    return;
  }
  formularioHome.submit();
}

function obtenerContenedores() {
  for (let index = 0; index < hometimeLine.children.length; index++) {
    if (
      hometimeLine.children[index].classList.contains(
        "home_timeline_contenido_posts"
      )
    ) {
      let hijosContenedorPost = hometimeLine.children[index].children;
      if (hijosContenedorPost.length === 2) {
        let hijo = hijosContenedorPost[0];
        arrayContenedores.push(hijo);
      }
    }
  }
}

function asignarEventosContenedores() {
  obtenerContenedores();
  for (let index = 0; index < arrayContenedores.length; index++) {
    arrayContenedores[index].addEventListener("click", realizarOperacion);
  }
}

function realizarOperacion(e) {
  if (e.target.classList.contains("operacion_like")) {
    operacionLikePost(e.target);
  } else {
    return;
  }
}

function operacionLikePost(elemento) {
  let operacion = "";
  if (elemento.classList[2].toLowerCase() === "unlike") {
    operacion = "like";
  } else if (elemento.classList[2].toLowerCase() === "like") {
    operacion = "unlike";
  }
  let idLike = 0;
  let idPost = parseInt(elemento.id.split("_")[1].split("-")[0]);
  let idPropio = parseInt(elemento.id.split("_")[1].split("-")[1]);
  let idUsuarioLike = parseInt(elemento.id.split("_")[1].split("-")[2]);
  api.operacionLike(
    idLike,
    idPost,
    idPropio,
    operacion,
    elemento,
    idUsuarioLike
  );
}

asignarEventosContenedores();
