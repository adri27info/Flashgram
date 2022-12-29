import * as api from "./api_auth.js";
const formularioLogin = document.getElementById("formulario_login");
const correo = formularioLogin.correo;
const password = formularioLogin.password;
const inputs = document.getElementsByTagName("input");
const expresiones = {
  correo:
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
  password: /^[a-zA-Z0-9_/,.]{4,20}$/,
};
const validaciones = {
  correo: false,
  password: false,
};

formularioLogin.addEventListener("submit", (e) => {
  e.preventDefault();
  enviarFormulario(e);
});

function enviarFormulario(e) {
  let contador = obtenerValidaciones();
  if (contador === 2) {
    api.mostrarUsuario(correo.value, password.value);
  } else {
    let contenedores = document.querySelectorAll("#formulario_login div");
    contenedores.forEach((element) => {
      let contenedor = element.classList[0];
      for (let iterator in validaciones) {
        if (validaciones[iterator] === false) {
          let cadena = "contenedor_" + iterator + "_validacion";
          if (cadena === contenedor.toLocaleLowerCase())
            element.classList.remove("ocultar");
        }
      }
    });
  }
}

function asignarEventosInputs() {
  for (let index = 0; index < inputs.length; index++) {
    if (inputs[index].type === "text" || inputs[index].type === "password") {
      inputs[index].addEventListener("blur", validarFormulario);
      inputs[index].addEventListener("keyup", validarFormulario);
    }
  }
}

function validarFormulario(e) {
  switch (e.target.id) {
    case "correo":
      validarCampo(
        correo.value,
        expresiones.correo,
        "error_correo_validacion",
        "correo"
      );
      break;
    case "password":
      validarCampo(
        password.value,
        expresiones.password,
        "error_password_validacion",
        "password"
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

function obtenerValidaciones() {
  let conteo = 0;
  for (let key in validaciones) {
    if (validaciones[key] === true) {
      conteo++;
    }
  }
  return conteo;
}

asignarEventosInputs();
