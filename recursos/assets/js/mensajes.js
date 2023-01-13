import * as home from "./main.js";

const formularioMensaje = document.getElementById("formulario_mensaje");
const contenido = formularioMensaje.contenido;
const expresiones = {
  contenido: /^[a-zA-ZÀ-ÿ\u00f1\u00d1]{2,}.*/,
};
const validaciones = {
  contenido: false,
};

formularioMensaje.addEventListener("submit", (e) => {
  e.preventDefault();
  enviarFormulario(e);
});

function enviarFormulario(e) {
  let contador = 0;
  for (let key in validaciones) {
    if (validaciones[key] === true) {
      contador++;
    }
  }
  if (contador === 1) {
    formularioMensaje.submit();
  } else {
    let contenedor = document.getElementById("formulario_mensaje_contenido");
    for (let iterator in validaciones) {
      if (validaciones[iterator] === false) {
        contenedor.classList.remove("ocultar");
      }
    }
  }
}

function asignarEventosFormularioMensaje() {
  contenido.addEventListener("blur", validarFormularioMensaje);
  contenido.addEventListener("keyup", validarFormularioMensaje);
}

function validarFormularioMensaje(e) {
  switch (e.target.id) {
    case "contenido":
      validarCampo(
        contenido.value,
        expresiones.contenido,
        "error_contenido_validacion",
        "contenido"
      );
      break;
    default:
      break;
  }
}

function validarCampo(valor, expresion, textoSpan, nombre) {
  let contenedorSpan = document.getElementById(textoSpan).parentNode;
  if (!expresion.test(valor)) {
    contenedorSpan.classList.remove("ocultar");
    validaciones[nombre] = false;
  } else {
    contenedorSpan.classList.add("ocultar");
    validaciones[nombre] = true;
  }
}

asignarEventosFormularioMensaje();
