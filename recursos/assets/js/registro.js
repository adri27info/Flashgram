import * as api from "./api_auth.js";
const formularioRegistro = document.getElementById("formulario_registro");
const nombre = formularioRegistro.nombre;
const apellidos = formularioRegistro.apellidos;
const correo = formularioRegistro.correo;
const password = formularioRegistro.password;
const inputs = document.getElementsByTagName("input");
const expresiones = {
  nombre:
    /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+\s?[a-zA-ZÀ-ÿ\u00f1\u00d1]+\s?[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/,
  correo:
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
  password: /^[a-zA-Z0-9_/,.]{4,20}$/,
};
const validaciones = {
  nombre: false,
  correo: false,
  password: false,
};

formularioRegistro.addEventListener("submit", (e) => {
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
  if (contador === 3) {
    api.registrarUsuario(nombre.value, correo.value, password.value);
  } else {
    let contenedores = document.querySelectorAll("#formulario_registro div");
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
  limpiarInputs();
  for (let index = 0; index < inputs.length; index++) {
    if (inputs[index].type === "text" || inputs[index].type === "password") {
      inputs[index].addEventListener("blur", validarFormulario);
      inputs[index].addEventListener("keyup", validarFormulario);
    }
  }
}

function validarFormulario(e) {
  switch (e.target.id) {
    case "nombre":
      validarCampo(
        nombre.value,
        expresiones.nombre,
        "error_nombre_validacion",
        "nombre"
      );
      break;
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
    console.log("1");
    contenedorSpan.classList.remove("ocultar");
    validaciones[nombre] = false;
  } else {
    console.log("2");
    contenedorSpan.classList.add("ocultar");
    validaciones[nombre] = true;
  }
}

function limpiarInputs() {
  nombre.value = "";
  correo.value = "";
  password.value = "";
}

asignarEventosInputs();
