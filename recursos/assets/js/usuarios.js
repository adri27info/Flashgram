import * as home from "./main.js";
import * as api from "./api_main.js";

const usuarios = document.getElementById("usuarios");
let arrayContenedoresFollow = [];

function obtenerContenedoresFollow() {
  for (let index = 0; index < usuarios.children.length; index++) {
    if (usuarios.children[index].classList.contains("usuarios_informacion")) {
      let hijosContenedorInformacion = usuarios.children[index].children;
      if (hijosContenedorInformacion.length === 2) {
        let hijoFollow = hijosContenedorInformacion[1];
        arrayContenedoresFollow.push(hijoFollow);
      }
    }
  }
}

function asignarEventosContenedoresFollow() {
  obtenerContenedoresFollow();
  for (let index = 0; index < arrayContenedoresFollow.length; index++) {
    arrayContenedoresFollow[index].addEventListener(
      "click",
      realizarFollowUsuario
    );
  }
}

function realizarFollowUsuario(e) {
  if (!e.target.classList.contains("usuarios_informacion_follow_contenedor")) {
    operacionFollowUsuario(e.target.parentElement);
  } else {
    operacionFollowUsuario(e.target);
  }
}

function operacionFollowUsuario(parent) {
  let operacion = parent.children[1].textContent.toLowerCase();
  let array = parent.id.split("_");
  let obtenerIds = array[array.length - 1].split("-");
  let idUsuarioPropio = parseInt(obtenerIds[0]);
  let idUsuarioFollow = parseInt(obtenerIds[1]);
  api.operacionFollow(idUsuarioPropio, idUsuarioFollow, parent, operacion);
}

asignarEventosContenedoresFollow();
