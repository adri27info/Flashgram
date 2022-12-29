const url_api =
  "/apps/php/Flashgram/recursos/utilidades/conectividad/apis/api_main.php";

async function operacionLike(
  idLike,
  idPost,
  idPropio,
  operacion,
  elemento,
  idUsuarioLike
) {
  try {
    let method = "";
    if (operacion === "unlike") {
      method = "unlike";
    } else {
      method = "like";
    }
    const res = await fetch(url_api, {
      method: "POST",
      headers: { "Content-type": "application/json; charset=utf-8" },
      body: JSON.stringify({
        id_like: idLike,
        id_post: idPost,
        id_usuario: idPropio,
        id_usuario_like: idUsuarioLike,
        metodo: method,
        acto: "operacion_like",
      }),
    });
    const data = await res.json();
    switch (res.status) {
      case 200:
        if (Object.keys(data).includes("error")) {
          cambiarIconoLike(elemento, data.error, "error");
        } else {
          if (Object.keys(data).includes("like")) {
            cambiarIconoLike(elemento, data.exito, "exito", data.like);
          } else {
            cambiarIconoLike(elemento, data.exito, "exito", data.unlike);
          }
        }
        break;
      case 404:
        if (Object.keys(data).includes("error_comprobacion")) {
          cambiarIconoLike(
            elemento,
            data.error_comprobacion,
            "error_comprobacion"
          );
        }
        break;
      default:
        break;
    }
  } catch (error) {
    console.log(error);
  }
}

async function operacionFollow(idPropio, idUsuarioFollow, parent, operacion) {
  try {
    let method = "";
    if (operacion === "seguir") {
      method = "follow";
    } else {
      method = "unfollow";
    }
    const res = await fetch(url_api, {
      method: "POST",
      headers: { "Content-type": "application/json; charset=utf-8" },
      body: JSON.stringify({
        id_usuario: idPropio,
        id_usuario_seguido: idUsuarioFollow,
        metodo: method,
        acto: "operacion_follow",
      }),
    });
    const data = await res.json();
    switch (res.status) {
      case 200:
        if (Object.keys(data).includes("error")) {
          cambiarIconosFollowUsuario(parent, data.error, "error");
        } else {
          if (Object.keys(data).includes("follow")) {
            cambiarIconosFollowUsuario(
              parent,
              data.exito,
              "exito",
              data.follow
            );
          } else {
            cambiarIconosFollowUsuario(
              parent,
              data.exito,
              "exito",
              data.unfollow
            );
          }
        }
        break;
      case 404:
        if (Object.keys(data).includes("error_comprobacion")) {
          cambiarIconosFollowUsuario(
            parent,
            data.error_comprobacion,
            "error_comprobacion"
          );
        }
        break;
      default:
        break;
    }
  } catch (error) {
    console.log(error);
  }
}

function cambiarIconoLike(elemento, mensaje, palabraKey, textoLike) {
  if (palabraKey === "error_comprobacion" || palabraKey === "error") {
    alert(mensaje);
    return;
  }
  if (palabraKey === "exito") {
    if (elemento.classList.contains("unlike")) {
      elemento.classList.remove("unlike");
      elemento.classList.add("like");
    } else if (elemento.classList.contains("like")) {
      elemento.classList.remove("like");
      elemento.classList.add("unlike");
    }
    alert(mensaje);
  }
  if (textoLike === "+" || textoLike === "-") {
    if (document.getElementById("span_likes") !== null) {
      let spanLikes = document.getElementById("span_likes");
      let cantidadLikes = parseInt(spanLikes.textContent);
      switch (textoLike) {
        case "+":
          cantidadLikes = cantidadLikes + 1;
          spanLikes.textContent = cantidadLikes;
          break;
        case "-":
          cantidadLikes = cantidadLikes - 1;
          spanLikes.textContent = cantidadLikes;
          break;
        default:
          break;
      }
    }
  }
}

function cambiarIconosFollowUsuario(parent, mensaje, palabraKey, textoFollow) {
  if (palabraKey === "error_comprobacion" || palabraKey === "error") {
    alert(mensaje);
    return;
  }
  if (palabraKey === "exito") {
    let btnFollowUsuario = parent.children[0];
    let textoBtnFollowUsuario = parent.children[1];
    if (btnFollowUsuario.textContent === "arrow_right_alt") {
      btnFollowUsuario.classList.remove("seguir");
      btnFollowUsuario.classList.add("no_seguir");
      btnFollowUsuario.textContent = "block";
    } else {
      btnFollowUsuario.classList.remove("no_seguir");
      btnFollowUsuario.classList.add("seguir");
      btnFollowUsuario.textContent = "arrow_right_alt";
    }
    if (textoBtnFollowUsuario.textContent === "Seguir") {
      textoBtnFollowUsuario.textContent = "Dejar de seguir";
    } else {
      textoBtnFollowUsuario.textContent = "Seguir";
    }
    alert(mensaje);
  }
  if (textoFollow === "->" || textoFollow === "<-") {
    if (document.getElementById("span_follower") !== null) {
      let spanFollower = document.getElementById("span_follower");
      let cantidadFollowers = parseInt(spanFollower.textContent);
      switch (textoFollow) {
        case "->":
          cantidadFollowers = cantidadFollowers + 1;
          spanFollower.textContent = cantidadFollowers;
          break;
        case "<-":
          cantidadFollowers = cantidadFollowers - 1;
          spanFollower.textContent = cantidadFollowers;
          break;
        default:
          break;
      }
    }
  }
}

export { operacionFollow, operacionLike };
