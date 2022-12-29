import * as main from "./main.js";
import * as api from "./api_main.js";

let arrayContenedoresFollow = [];
let arrayContenedoresLike = [];

//FOLLOWS
function obtenerContenedoresFollow() {
  if (
    document.querySelector(
      ".usuario_datos_biografia_stats_contenedor_follow_follower"
    ) !== null
  ) {
    let contenedorLike = document.querySelector(
      ".usuario_datos_biografia_stats_contenedor_follow_follower"
    );
    for (let index = 0; index < contenedorLike.children.length; index++) {
      arrayContenedoresFollow.push(contenedorLike.children[index]);
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
  if (
    !e.target.classList.contains(
      "usuario_datos_biografia_stats_contenedor_follow_follower"
    )
  ) {
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

//LIKES
function obtenerContenedoresLike() {
  if (document.querySelector(".usuario_posts") !== null) {
    let contenedorPosts = document.querySelectorAll(".usuario_posts");
    contenedorPosts.forEach((element) => {
      let contenedorDatosUsuario = element.children[0];
      if (contenedorDatosUsuario.children.length === 3) {
        let contenedorLike = contenedorDatosUsuario.children[2];
        arrayContenedoresLike.push(contenedorLike);
      }
    });
  }
}

function asignarEventosContenedoresLike() {
  obtenerContenedoresLike();
  for (let index = 0; index < arrayContenedoresLike.length; index++) {
    arrayContenedoresLike[index].addEventListener("click", realizarLikeUsuario);
  }
}

function realizarLikeUsuario(e) {
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

asignarEventosContenedoresFollow();
asignarEventosContenedoresLike();
