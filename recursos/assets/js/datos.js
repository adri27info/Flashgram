import * as home from "./main.js";

const formularioPerfil = document.getElementById("datos_perfil_formulario");
const nombre = formularioPerfil.nombre;
const biografia = formularioPerfil.biografia;
const expresiones = {
  nombre: /^[a-zA-ZÀ-ÿ]{2,30}$/,
  biografia: /^[^'*]{2,255}$/,
};
const validaciones = {
  nombre: false,
  biografia: false,
};

formularioPerfil.addEventListener("submit", (e) => {
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
  if (contador === 2) {
    formularioPerfil.submit();
  } else {
    let contenedores = document.querySelectorAll(
      "#datos_perfil_formulario div"
    );
    contenedores.forEach((element) => {
      let contenedor = element.classList[0];
      for (let iterator in validaciones) {
        if (validaciones[iterator] === false) {
          let cadena = "datos_perfil_formulario_" + iterator;
          if (cadena === contenedor.toLocaleLowerCase())
            element.classList.remove("ocultar");
        }
      }
    });
  }
}

function asignarEventosFormularioPerfil() {
  nombre.addEventListener("blur", validarFormularioPerfil);
  nombre.addEventListener("keyup", validarFormularioPerfil);
  biografia.addEventListener("blur", validarFormularioPerfil);
  biografia.addEventListener("keyup", validarFormularioPerfil);
}

function validarFormularioPerfil(e) {
  switch (e.target.id) {
    case "nombre":
      validarCampo(
        nombre.value,
        expresiones.nombre,
        "error_nombre_validacion",
        "nombre"
      );
      break;
    case "biografia":
      validarCampo(
        biografia.value,
        expresiones.biografia,
        "error_biografia_validacion",
        "biografia"
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

asignarEventosFormularioPerfil();
