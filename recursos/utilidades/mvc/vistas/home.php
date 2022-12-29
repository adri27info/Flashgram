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
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/home.js" defer type="module"></script>
</head>

<body id="body">
  <?php include("componentes/header_main.php"); ?>
  <section class="home" id="home">
    <div class="home_timeline" id="home_timeline">
      <h1 class="home_timeline_titulo">Timeline</h1>
      <hr class='home_timeline_separador'>
      <?php
      //Subida del post de la pagina home
      if (isset($_SESSION["post_subido_imagen_error_tipo"])) {
        echo "<p class='home_timeline_parrafo_error_post'>"  . $_SESSION["post_subido_imagen_error_tipo"] .  "</p>";
        unset($_SESSION["post_subido_imagen_error_tipo"]);
      } else if (isset($_SESSION["post_subido_imagen_error_insertar"])) {
        echo "<p class='home_timeline_parrafo_error_post'>"  . $_SESSION["post_subido_imagen_error_insertar"] .  "</p>";
        unset($_SESSION["post_subido_imagen_error_insertar"]);
      } else if (isset($_SESSION["post_subido_imagen_error_registrar"])) {
        echo "<p class='home_timeline_parrafo_error_post'>"  . $_SESSION["post_subido_imagen_error_registrar"] .  "</p>";
        unset($_SESSION["post_subido_imagen_error_registrar"]);
      } else if (isset($_SESSION["post_subido_imagen_exito"])) {
        echo "<p class='home_timeline_parrafo_exito_post'>"  . $_SESSION["post_subido_imagen_exito"] .  "</p>";
        unset($_SESSION["post_subido_imagen_exito"]);
      }

      //Borrado del post de la pagina home
      if (isset($_SESSION["post_borrado_exito"])) {
        echo "<p class='home_timeline_parrafo_exito_post'>"  . $_SESSION["post_borrado_exito"] .  "</p>";
        unset($_SESSION["post_borrado_exito"]);
      } else if (isset($_SESSION["post_borrado_error"])) {
        echo "<p class='home_timeline_parrafo_error_post'>"  . $_SESSION["post_borrado_error"] .  "</p>";
        unset($_SESSION["post_borrado_error"]);
      }

      //Mostrar los posts de la pagina home
      if ($posts && count($posts) > 0) {
        echo "<p class='home_timeline_parrafo_posts'> Posts totales: " . count($posts) . "</p>";
        foreach ($posts as $key => $objeto) {
          echo "<div class='home_timeline_contenido_posts' id='home_timeline_contenido_posts'>";
          echo "<div class='home_timeline_contenido_posts_datos'>";
          echo "<div class='home_timeline_contenido_posts_datos_imagen'>";
          echo "<img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
          echo "</div>";
          echo "<div class='home_timeline_contenido_posts_datos_usuario'>";
          echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . ">" . $objeto->nombre . "</a>";
          echo "<span>" . $objeto->correo . "</span>";
          echo "<span>" . $objeto->fecha_post . "</span>";
          echo "</div>";
          if ($_SESSION["usuario"] !== $objeto->correo) {
            if ($obtenerLikesUsuarioPost && count($obtenerLikesUsuarioPost) > 0) {
              $condicion = false;
              foreach ($obtenerLikesUsuarioPost as $key => $item) {
                //echo "{ " . $objeto->id_post . " " . $item->id_post . " " . $item->id_usuario . " " . $_SESSION["id_usuario"] .  "}" . "<br> <br>";
                if ($objeto->id_post === $item->id_post && $_SESSION["id_usuario"] === $item->id_usuario) {
                  echo "<div class='home_timeline_contenido_posts_datos_likes'>";
                  echo "<span class='material-symbols-outlined operacion_like like' id='span_" . $objeto->id_post . "-" . $_SESSION["id_usuario"] . "-" .
                    $objeto->id_usuario . "'> favorite </span>";
                  echo "</div>";
                  $condicion = true;
                  break;
                }
              }
              if ($condicion !== true) {
                echo "<div class='home_timeline_contenido_posts_datos_likes'>";
                echo "<span class='material-symbols-outlined operacion_like unlike' id='span_" . $objeto->id_post . "-" . $_SESSION["id_usuario"] . "-" .
                  $objeto->id_usuario . "'> favorite </span>";
                echo "</div>";
              }
            } else {
              echo "<div class='home_timeline_contenido_posts_datos_likes'>";
              echo "<span class='material-symbols-outlined operacion_like unlike' id='span_" . $objeto->id_post . "-" . $_SESSION["id_usuario"] . "-" .
                $objeto->id_usuario . "'> favorite </span>";
              echo "</div>";
            }
          } else {
            echo "<div class='home_timeline_contenido_posts_datos_borrar'>";
            echo "<form action='" . CHILD_ROOT_PATH  . "main/home" . "' method='post'>";
            echo "<input type='hidden' name='id_post' value='" . $objeto->id_post . "'>";
            echo "<input type='hidden' name='borrar_post'>";
            echo "<button type='submit' name='btnFormularioDeletePost'>";
            echo "<span class='material-symbols-outlined'> delete </span>";
            echo "</button>";
            echo "</form>";
            echo "</div>";
          }
          echo "</div>";
          echo "<div class='home_timeline_contenido_posts_informacion'>";
          echo "<p>" . $objeto->mensaje  . "</p>";
          if ($objeto->archivo_adjunto !== NULL) {
            echo "<img src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
          }
          echo "</div>";
          echo "</div>";
        }
      } else {
        echo "<p class='home_timeline_parrafo_posts'>  No hay posts que mostrar </p>";
      }
      ?>
    </div>
    <div class="home_posts">
      <div class="home_posts_perfil">
        <?php
        echo "<div class='home_posts_perfil_imagen'>";
        echo "<img src='data:image/" . $_SESSION["usuario_logueado"]->tipo_imagen . ";base64," . base64_encode($_SESSION["usuario_logueado"]->imagen) . "' alt='user-photo-db'>";
        echo "</div>";
        echo "<div class='home_posts_perfil_datos'>";
        echo "<a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["usuario_logueado"]->correo . "'>" . $_SESSION["usuario_logueado"]->nombre . "</a>";
        if ($_SESSION["usuario_logueado"]->id_rol === "2") echo "<span> usuario </span>";
        else "<span> admin </span>";
        echo "</div>";
        echo "<hr class='home_posts_perfil_separador'>";
        echo "<div class='home_post_perfil_estadisticas'>";
        echo "<div class='home_post_perfil_estadisticas_following'>";
        echo "<span class='home_post_perfil_estadisticas_following_titulo'> <a href='" . CHILD_ROOT_PATH . "estadisticas/index'> Siguiendo </a>    </span>";
        echo "<span class='home_post_perfil_estadisticas_following_texto'>" . $_SESSION["usuario_logueado"]->following_cantidad . "</span>";
        echo "</div>";
        echo "<div class='home_post_perfil_estadisticas_followers'>";
        echo "<span class='home_post_perfil_estadisticas_followers_titulo'><a href='" . CHILD_ROOT_PATH . "estadisticas/index'> Seguidores </a> </span>";
        echo "<span class='home_post_perfil_estadisticas_followers_texto'>" . $_SESSION["usuario_logueado"]->followers_cantidad . "</span>";
        echo "</div>";
        echo "<div class='home_post_perfil_estadisticas_posts'>";
        echo "<span class='home_post_perfil_estadisticas_posts_titulo'><a href='" . CHILD_ROOT_PATH . "estadisticas/index'> Posts </a> </span>";
        echo "<span class='home_post_perfil_estadisticas_posts_texto'>" . $_SESSION["usuario_logueado"]->posts_cantidad . "</span>";
        echo "</div>";
        echo "<div class='home_post_perfil_estadisticas_likes'>";
        echo "<span class='home_post_perfil_estadisticas_likes_titulo'><a href='" . CHILD_ROOT_PATH . "estadisticas/index'> Likes </a> </span>";
        echo "<span class='home_post_perfil_estadisticas_likes_texto' id='span_likes'>" .  $_SESSION["usuario_logueado"]->likes_cantidad . "</span>";
        echo "</div>";
        echo "</div>";
        ?>
      </div>
      <div class="home_posts_contenido">
        <h1 class="home_posts_contenido_titulo">Crear post</h1>
        <hr class="home_posts_contenido_titulo_seperador">
        <form action="<?= CHILD_ROOT_PATH ?>main/home" method="post" class="home_posts_contenido_formulario"
          id="formulario_home" enctype="multipart/form-data">
          <label for="home_posts_contenido_formulario_textarea">Mensaje</label>
          <textarea class="home_posts_contenido_formulario_textarea" id="mensaje"
            placeholder="Introduce el texto del post" name="mensaje" maxlength="255"></textarea>
          <input type="file" name="imagen" class="home_posts_contenido_formulario_imagen" id="imagen">
          <input type="hidden" name="subir_post">
          <input type="submit" value="Enviar" name="btnHome" id="btnHome">
        </form>
      </div>
    </div>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>