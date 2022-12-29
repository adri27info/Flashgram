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
  <section class="mensajes_enviados">
    <h1 class="mensajes_enviados_titulo">Mensajes enviados</h1>
    <?php
    if (isset($_SESSION["conversaciones_enviadas"])) {
      echo "<div class='mensajes_enviados_contenedor'>";
      echo "<span class='mensajes_enviados_contenedor_total'>Total de mensajes enviados - " . count($_SESSION["conversaciones_enviadas"]) . "</span>";
      foreach ($_SESSION["conversaciones_enviadas"] as $key => $objeto) {
        echo "<div class='mensajes_enviados_contenedor_datos'>";
        echo "<div class='mensajes_enviados_contenedor_datos_imagenes'>";
        echo "<img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db'>";
        echo "<span class='material-symbols-outlined'>chevron_right </span>";
        echo "<img src='data:image/" . $_SESSION["usuarios_conversaciones_enviadas"][$key]->tipo_imagen . ";base64," . base64_encode($_SESSION["usuarios_conversaciones_enviadas"][$key]->imagen) . "' alt='user-photo-db'>";
        echo "</div>";
        echo "<div class='mensajes_enviados_contenedor_datos_textos'>";
        echo "<span> <a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . ">" . $objeto->nombre . "</a> - 
          <a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["usuarios_conversaciones_enviadas"][$key]->correo . ">" . $_SESSION["usuarios_conversaciones_enviadas"][$key]->nombre . "</a> </span>";
        echo "<span>" . $objeto->fecha_mensaje_transmitido . "</span>";
        echo "</div>";
        echo "<div class='mensajes_enviados_contenedor_datos_informacion'>";
        echo "<p>" . $objeto->mensaje_transmitido . "</p>";
        if ($objeto->imagen_ufm !== NULL) {
          echo "<img style='width: 100%;'   src='data:image/" . $objeto->tipo_imagen_ufm . ";base64," . base64_encode($objeto->imagen_ufm) . "' alt='user-photo-db-post'>";
        }
        echo "</div>";
        echo "</div>";
      }
      echo "</div>";
      unset($_SESSION["conversaciones_enviadas"]);
      unset($_SESSION["usuarios_conversaciones_enviadas"]);
    } else {
      echo "<p class='mensajes_enviados_parrafo'> Actualmente este usuario no ah enviado mensajes</p>";
    }
    ?>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>