const btnOpciones = document.getElementById("btnOpciones");
const dropdown_contenido = document.getElementById("dropdown_contenido");
const btnSubir = document.getElementById("boton_subir");

btnOpciones.addEventListener("click", abrirOpciones);
btnSubir.addEventListener("click", subir);

function abrirOpciones() {
  if (dropdown_contenido.classList.contains("mostrar") === false) {
    dropdown_contenido.classList.add("mostrar");
  } else {
    dropdown_contenido.classList.remove("mostrar");
  }
}

function subir() {
  document.getElementById("logo").scrollIntoView({
    behavior: "smooth",
  });
}
