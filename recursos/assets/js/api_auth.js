const formularioLogin = document.getElementById("formulario_login");
const formularioRegistro = document.getElementById("formulario_registro");
const btnRegistro = document.getElementById("btnRegistro");
const btnLogin = document.getElementById("btnLogin");
const token = document.getElementById("token");
const url_api =
  "/apps/php/Flashgram/recursos/utilidades/conectividad/apis/api_auth.php";

async function registrarUsuario(n, c, p) {
  try {
    const res = await fetch(url_api, {
      method: "POST",
      headers: { "Content-type": "application/json; charset=utf-8" },
      body: JSON.stringify({
        nombre: n,
        correo: c,
        password: p,
        metodo: "registrar",
      }),
    });
    const data = await res.json();
    switch (res.status) {
      case 200:
        if (Object.keys(data).includes("error")) {
          crearMensajeOperacion(data.error, "formulario_registro");
        } else {
          crearMensajeOperacion(data.exito, "formulario_registro");
          enviarFormularioRegistro();
        }
        break;
      case 404:
        if (Object.keys(data).includes("error_comprobacion")) {
          crearMensajeOperacion(data.error_comprobacion, "formulario_registro");
        }
        break;
      default:
        break;
    }
  } catch (error) {
    console.log(error);
  }
}

async function mostrarUsuario(c, p) {
  try {
    const res = await fetch(url_api, {
      method: "POST",
      headers: { "Content-type": "application/json; charset=utf-8" },
      body: JSON.stringify({
        correo: c,
        password: p,
        metodo: "mostrar",
      }),
    });
    const data = await res.json();
    switch (res.status) {
      case 200:
        if (Object.keys(data).includes("error")) {
          crearMensajeOperacion(data.error, "formulario_login");
        } else {
          crearMensajeOperacion(data.exito, "formulario_login", data.token);
          enviarFormularioLogin(data.rol);
        }
        break;
      case 404:
        if (Object.keys(data).includes("error_comprobacion")) {
          crearMensajeOperacion(data.error_comprobacion, "formulario_login");
        }
        break;
      default:
        break;
    }
  } catch (error) {
    console.log(error);
  }
}

function crearMensajeOperacion(mensaje, idFormulario, tokenMensaje = "") {
  if (tokenMensaje !== "") token.value = tokenMensaje;
  borrarMensajeOperacion();
  const formulario = document.getElementById(idFormulario);
  const seccion = document.createElement("section");
  seccion.classList.add("verificacion");
  const parrafo = document.createElement("p");
  parrafo.classList.add("verificacion_parrafo");
  parrafo.textContent = mensaje;
  seccion.appendChild(parrafo);
  formulario.insertAdjacentElement("afterend", seccion);
}

function borrarMensajeOperacion() {
  const body = document.getElementById("body");
  const bodyNodes = body.children;
  for (let index = 0; index < bodyNodes.length; index++) {
    if (bodyNodes[index].classList.contains("verificacion")) {
      body.removeChild(body.children[index]);
    }
  }
}

function enviarFormularioRegistro() {
  btnRegistro.disabled = true;
  btnRegistro.style.cursor = "not-allowed";
  setTimeout(function () {
    formularioRegistro.submit();
  }, 2500);
}

function enviarFormularioLogin(rol) {
  let redireccion = "";
  if (rol === "admin") redireccion = "/apps/php/Flashgram/config/admin";
  else if (rol === "usuario") redireccion = "/apps/php/Flashgram/main/home";
  formularioLogin.action = redireccion;
  btnLogin.disabled = true;
  btnLogin.style.cursor = "not-allowed";
  console.log(formularioLogin.action);
  setTimeout(function () {
    formularioLogin.submit();
  }, 2500);
}

export { mostrarUsuario, registrarUsuario };
