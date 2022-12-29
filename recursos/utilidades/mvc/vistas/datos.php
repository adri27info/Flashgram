<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashgram</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="<?= CHILD_ROOT_PATH ?>recursos/assets/css/estilos.css" />
  <link rel="shortcut icon" href="<?= CHILD_ROOT_PATH ?>recursos/assets/images/favicon.ico" type="image/x-icon" />
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/datos.js" type="module" defer></script>
</head>

<body id="body">
  <?php include("componentes/header_main.php"); ?>
  <section class="datos" id="datos">
    <h1 class="datos_titulo">Editar perfil personal</h1>
    <hr class="datos_separador">
    <?php
    if (isset($_SESSION["editar_perfil_imagen_tipo_error"])) {
      echo "<p class='parrafo_datos_error'>" .  $_SESSION["editar_perfil_imagen_tipo_error"] . "</p>";
      unset($_SESSION["editar_perfil_imagen_tipo_error"]);
    } else if (isset($_SESSION["editar_perfil_error"])) {
      echo "<p class='parrafo_datos_error'>" .  $_SESSION["editar_perfil_error"] . "</p>";
      unset($_SESSION["editar_perfil_error"]);
    } else if (isset($_SESSION["editar_perfil_exito"])) {
      echo "<p class='parrafo_datos_exito'>" .  $_SESSION["editar_perfil_exito"] . "</p>";
      unset($_SESSION["editar_perfil_exito"]);
    }
    ?>
    <div class="datos_perfil">
      <form action="<?= CHILD_ROOT_PATH ?>main/datos" method="post" class="datos_perfil_formulario"
        id="datos_perfil_formulario" enctype="multipart/form-data">
        <label for="datos_perfil_formulario_nombre">Nombre</label>
        <input type="text" name="nombre" class="datos_perfil_formulario_nombre" id="nombre"
          placeholder="Introduce el nombre">
        <div class="datos_perfil_formulario_nombre ocultar">
          <span class="material-symbols-outlined"> person </span>
          <span id="error_nombre_validacion" class="error_nombre_validacion">Error [-2, +30]. Debes
            introducir entre 2 y 30 caracteres</span>
        </div>
        <label for="datos_perfil_formulario_biografia">Biografia</label>
        <textarea class="datos_perfil_formulario_biografia" id="biografia"
          placeholder="Introduce el texto de la biografia" name="biografia"></textarea>
        <div class="datos_perfil_formulario_biografia ocultar">
          <span class="material-symbols-outlined">
            description
          </span>
          <span id="error_biografia_validacion" class="error_biografia_validacion">Error [-2, +255]. Debes
            introducir entre 2 y 255 caracteres</span>
        </div>
        <label for="datos_perfil_formulario_imagen">Imagen</label>
        <input type="file" name="imagen" class="datos_perfil_formulario_imagen" id="datos_perfil_formulario_imagen">
        <input type="hidden" name="editar_perfil">
        <input type="submit" value="Enviar" name="btnHome" id="btnEditarPerfil">
      </form>
    </div>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>