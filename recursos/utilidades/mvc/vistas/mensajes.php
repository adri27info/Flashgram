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
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/mensajes.js" type="module" defer></script>
</head>

<body id="body">
  <?php include("componentes/header_main.php"); ?>
  <section class="mensajes">
    <h1 class="mensajes_titulo">Mensajeria privada</h1>
    <div class="mensajes">
      <div class="mensajes_enviar">
        <span class="mensajes_enviar_texto">Enviar mensaje privado</span>
        <?php
        if (isset($_SESSION["conversacion_usuario_imagen_error"])) {
          echo "<p class='mensajes_error'> " . $_SESSION["conversacion_usuario_imagen_error"] .  "</p>";
          unset($_SESSION["conversacion_usuario_imagen_error"]);
        } else if (isset($_SESSION["conversacion_usuario_error"])) {
          echo "<p class='mensajes_error'> " . $_SESSION["conversacion_usuario_error"] .  "</p>";
          unset($_SESSION["conversacion_usuario_error"]);
        } else if (isset($_SESSION["conversacion_usuario_exito"])) {
          echo "<p class='mensajes_exito'> " . $_SESSION["conversacion_usuario_exito"] .  "</p>";
          unset($_SESSION["conversacion_usuario_exito"]);
        }
        ?>
        <?php
        if (count($usuarios) == 1) {
          echo "<p class='mensajes_info'> Actualmente no hay mas usuarios registrados para enviar mensajes privados </p>";
        } else {
        ?>
        <form action="<?= CHILD_ROOT_PATH ?>mensajes/index" method="post" class="formulario_mensaje"
          id="formulario_mensaje" enctype="multipart/form-data">
          <label for="selector_usuario">Para:</label>
          <select name="selector" id="selector_usuario">
            <?php
              foreach ($usuarios as $key => $objeto) {
                if ($objeto->correo !== $_SESSION["usuario"]) {
                  echo "<option value='" . $objeto->correo . "_" . $objeto->id_usuario . "'>" . $objeto->nombre . " - " . $objeto->correo . "</option>";
                }
              }
              ?>
          </select>
          <label for="contenido">Mensaje</label>
          <textarea class="formulario_mensaje_contenido" placeholder="Introduce el texto del mensaje" name="contenido"
            id="contenido" maxlength="255"></textarea>
          <div class="formulario_mensaje_contenido ocultar" id="formulario_mensaje_contenido">
            <span class="material-symbols-outlined">
              description
            </span>
            <span id="error_contenido_validacion" class="error_contenido_validacion">Error [-2, +255]. Debes introducir
              entre 2 y 255 caracteres</span>
          </div>
          <label for="imagen">Imagen</label>
          <input type="file" name="imagen" class="formulario_mensaje_imagen" id="imagen">
          <input type="hidden" name="enviar_mensaje_privado">
          <input type="submit" value="Enviar" name="btnMensajePrivado" id="btnMensajePrivado">
        </form>
        <?php
        }
        ?>
      </div>
      <div class="mensajes_enviar_enlaces">
        <a class="mensajes_enlace_enviados" href="<?= CHILD_ROOT_PATH ?>mensajes/enviados">Ver mensajes enviados</a>
        <a class="mensajes_enlace_enviados" href="<?= CHILD_ROOT_PATH ?>mensajes/recibidos">Ver mensajes recibidos</a>
      </div>
    </div>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>