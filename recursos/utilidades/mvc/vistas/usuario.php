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
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/usuario.js" defer type="module"></script>
</head>

<body id="body">
  <?php include("componentes/header_main.php"); ?>
  <section class="usuario" id="usuario">
    <?php
    //Borrado del post de la pagina usuario/index/?correo=?
    if (isset($_SESSION["post_borrado_exito"])) {
      echo "<p class='usuario_parrafo_exito_post'>"  . $_SESSION["post_borrado_exito"] . ", volver a la pagina del <a href='usuario/index/?correo=" . $_SESSION["usuario"] . "'> usuario actual </a>";
      unset($_SESSION["post_borrado_exito"]);
    } else if (isset($_SESSION["post_borrado_error"])) {
      echo "<p class='usuario_parrafo_error_post'>"  . $_SESSION["post_borrado_error"] . ", volver a la pagina del <a href='usuario/index/?correo=" . $_SESSION["usuario"] . "'> usuario actual </a>";
      unset($_SESSION["post_borrado_error"]);
    } else if (isset($_SESSION["usuario_logueado_encontrado"])) {
    ?>
    <div class="usuario_datos">
      <div class="usuario_datos_biografia">
        <div class="usuario_datos_biografia_imagen">
          <?php
            echo "<img src='data:image/" . $_SESSION["usuario_logueado"]->tipo_imagen . ";base64," . base64_encode($_SESSION["usuario_logueado"]->imagen) . "' alt='user-photo-db'>";
            ?>
        </div>
        <div class="usuario_datos_biografia_nombres">
          <?php
            echo "<span>" . $_SESSION["usuario_logueado"]->nombre .  "</span>";
            echo "<span>" .  $_SESSION["usuario_logueado"]->correo . "</span>";
            echo "<span>" .  $_SESSION["usuario_logueado"]->biografia . "</span>";
            ?>
        </div>
        <div class='usuario_datos_biografia_perfil'>
          <span class='material-symbols-outlined usuario_datos_biografia_perfi_propio'>done</span>
          <span> Perfil personal </span>
        </div>
      </div>
      <div class="usuario_datos_stats">
        <hr class="usuario_datos_stats_separador">
        <div class="usuario_datos_stats_following">
          <span><a href='<?= CHILD_ROOT_PATH ?>estadisticas/index'> Siguiendo </a></span>
          <span><?= $_SESSION["usuario_logueado"]->following_cantidad ?></span>
        </div>
        <div class="usuario_datos_stats_followers">
          <span><a href='<?= CHILD_ROOT_PATH ?>estadisticas/index'> Seguidores </a></span>
          <span><?= $_SESSION["usuario_logueado"]->followers_cantidad ?></span>
        </div>
        <div class="usuario_datos_stats_posts">
          <span><a href='<?= CHILD_ROOT_PATH ?>estadisticas/index'> Posts </a></span>
          <span><?= $_SESSION["usuario_logueado"]->posts_cantidad ?></span>
        </div>
        <div class="usuario_datos_stats_likes">
          <span><a href='<?= CHILD_ROOT_PATH ?>estadisticas/index'> Likes </a></span>
          <span><?= $_SESSION["usuario_logueado"]->likes_cantidad ?></span>
        </div>
        <hr class="usuario_datos_stats_separador">
      </div>
    </div>
    <?php
      if (isset($_SESSION["posts_usuario_logueado_encontrado"]) && count($_SESSION["posts_usuario_logueado_encontrado"]) > 0) {
        echo "<p class='usuario_parrafo_conteo'> Total de posts de este usuario: " . count($_SESSION["posts_usuario_logueado_encontrado"]) . "</p>";
        foreach ($_SESSION["posts_usuario_logueado_encontrado"] as $key => $objeto) {
          echo "<div class='usuario_posts '>";
          echo "<div class='usuario_posts_datos'>";
          echo "<div class='usuario_posts_datos_imagen'>";
          echo "<img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "'alt='user-photo-db-profile'>";
          echo "</div>";
          echo "<div class='usuario_posts_datos_usuario'>";
          echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . ">" . $objeto->nombre . "</a>";
          echo "<span> $objeto->correo </span>";
          echo "<span>$objeto->fecha_post </span>";
          echo "</div>";
          echo "<div class='usuario_posts_datos_borrar'>";
          echo "<form action='" . CHILD_ROOT_PATH  . "usuario/index/?correo=" . $objeto->correo .  "' method='post'>";
          echo "<input type='hidden' name='id_post' value='" . $objeto->id_post . "'>";
          echo "<input type='hidden' name='borrar_post'>";
          echo "<button type='submit' name='btnFormularioUsuarioDeletePost'>";
          echo "<span class='material-symbols-outlined'> delete </span>";
          echo "</button>";
          echo "</form>";
          echo "</div>";
          echo "</div>";
          echo "<div class='usuario_posts_informacion'>";
          echo "<p> $objeto->mensaje </p>";
          if ($objeto->archivo_adjunto !== NULL) {
            echo "<img style='width: 100%;'   src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
          }
          echo "</div>";
          echo "</div>";
        }
        unset($_SESSION["posts_usuario_logueado_encontrado"]);
      } else {
        echo "<div class='usuario_posts'>";
        echo "<p class='usuario_posts_conteo '> Total de posts de este usuario: 0 </p>";
        echo "</div>";
      }
      ?>
    <?php
      unset($_SESSION["usuario_logueado_encontrado"]);
    } else if (isset($_SESSION["usuario_distinto_encontrado_exito"])) {
    ?>
    <div class="usuario_datos">
      <div class="usuario_datos_biografia">
        <div class="usuario_datos_biografia_imagen">
          <?php
            echo "<img src='data:image/" . $_SESSION["usuario_distinto_encontrado_exito"]->tipo_imagen . ";base64," . base64_encode($_SESSION["usuario_distinto_encontrado_exito"]->imagen) . "' alt='user-photo-db'>";
            ?>
        </div>
        <div class="usuario_datos_biografia_nombres">
          <?php
            echo "<span>" . $_SESSION["usuario_distinto_encontrado_exito"]->nombre .  "</span>";
            echo "<span>" .  $_SESSION["usuario_distinto_encontrado_exito"]->correo . "</span>";
            echo "<span>" .  $_SESSION["usuario_distinto_encontrado_exito"]->biografia . "</span>";
            ?>
        </div>
        <div class="usuario_datos_biografia_stats_contenedor_follow">
          <div class="usuario_datos_biografia_stats_contenedor_follow_following">
            <span>
              <?php
                if (isset($_SESSION["follower"])) {
                  echo $_SESSION["follower"];
                  unset($_SESSION["follower"]);
                } else {
                  echo "No te sigue";
                }
                ?>
            </span>
          </div>
          <div class="usuario_datos_biografia_stats_contenedor_follow_follower"
            id="usuario_datos_biografia_stats_contenedor_follow_follower_<?= $_SESSION["id_usuario"] ?>-<?= $_SESSION["usuario_distinto_encontrado_exito"]->id_usuario ?>">
            <?php
              if (isset($_SESSION["following"])) {
                echo "<span class='material-symbols-outlined usuario_datos_biografia_stats_contenedor_follow_follower_boton no_seguir'>block</span>";
                echo "<span class='usuario_datos_biografia_stats_contenedor_follow_follower_texto'>" . $_SESSION["following"] . "</span>";
                unset($_SESSION["following"]);
              } else {
                echo "<span class='material-symbols-outlined usuario_datos_biografia_stats_contenedor_follow_follower_boton seguir'>arrow_right_alt</span>";
                echo "<span class='usuario_datos_biografia_stats_contenedor_follow_follower_texto'>Seguir</span>";
              }
              ?>
          </div>
        </div>
      </div>
      <div class="usuario_datos_stats">
        <hr class="usuario_datos_stats_separador">
        <div class="usuario_datos_stats_following">
          <span>
            <a
              href='<?= CHILD_ROOT_PATH ?>estadisticas/index/?email=<?= $_SESSION["usuario_distinto_encontrado_exito"]->correo ?>'>Siguiendo
            </a>
          </span>
          <span><?= $_SESSION["usuario_distinto_encontrado_exito"]->following_cantidad ?></span>
        </div>
        <div class="usuario_datos_stats_followers">
          <span>
            <a
              href='<?= CHILD_ROOT_PATH ?>estadisticas/index/?email=<?= $_SESSION["usuario_distinto_encontrado_exito"]->correo ?>'>Seguidores
            </a>
          </span>
          <span id="span_follower"><?= $_SESSION["usuario_distinto_encontrado_exito"]->followers_cantidad ?></span>
        </div>
        <div class="usuario_datos_stats_posts">
          <span>
            <a
              href='<?= CHILD_ROOT_PATH ?>estadisticas/index/?email=<?= $_SESSION["usuario_distinto_encontrado_exito"]->correo ?>'>Posts
            </a>
          </span>
          <span><?= $_SESSION["usuario_distinto_encontrado_exito"]->posts_cantidad ?></span>
        </div>
        <div class="usuario_datos_stats_likes">
          <span>
            <a
              href='<?= CHILD_ROOT_PATH ?>estadisticas/index/?email=<?= $_SESSION["usuario_distinto_encontrado_exito"]->correo ?>'>Likes
            </a>
          </span>
          <span><?= $_SESSION["usuario_distinto_encontrado_exito"]->likes_cantidad ?></span>
        </div>
        <hr class="usuario_datos_stats_separador">
      </div>
    </div>
    <?php
      if (isset($_SESSION["posts_usuario_distinto_encontrado"]) && count($_SESSION["posts_usuario_distinto_encontrado"]) > 0) {
        echo "<p class='usuario_parrafo_conteo'> Total de posts de este usuario: " . count($_SESSION["posts_usuario_distinto_encontrado"]) . "</p>";
        foreach ($_SESSION["posts_usuario_distinto_encontrado"] as $key => $objeto) {
          echo "<div class='usuario_posts' id ='usuario_posts'>";
          echo "<div class='usuario_posts_datos'>";
          echo "<div class='usuario_posts_datos_imagen'>";
          echo "<img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "'alt='user-photo-db-profile'>";
          echo "</div>";
          echo "<div class='usuario_posts_datos_usuario'>";
          echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . ">" . $objeto->nombre . "</a>";
          echo "<span> $objeto->correo </span>";
          echo "<span>$objeto->fecha_post </span>";
          echo "</div>";
          if (isset($_SESSION["likes_usuario_post"]) && count($_SESSION["likes_usuario_post"]) > 0) {
            $condicion = false;
            foreach ($_SESSION["likes_usuario_post"] as $key => $item) {
              if ($objeto->id_post === $item->id_post && $_SESSION["id_usuario"] === $item->id_usuario) {
                echo "<div class='usuario_posts_datos_likes'>";
                echo "<span class='material-symbols-outlined operacion_like like' id='span_" . $objeto->id_post . "-" . $_SESSION["id_usuario"]
                  . "-" . $objeto->id_usuario . "'> favorite </span>";
                echo "</div>";
                $condicion = true;
                break;
              }
            }
            if ($condicion !== true) {
              echo "<div class='usuario_posts_datos_likes'>";
              echo "<span class='material-symbols-outlined operacion_like unlike' id='span_" . $objeto->id_post . "-" . $_SESSION["id_usuario"]
                . "-" . $objeto->id_usuario . "'> favorite </span>";
              echo "</div>";
            }
          } else {
            echo "<div class='usuario_posts_datos_likes'>";
            echo "<span class='material-symbols-outlined operacion_like unlike' id='span_" . $objeto->id_post . "-" . $_SESSION["id_usuario"]
              . "-" . $objeto->id_usuario . "'> favorite </span>";
            echo "</div>";
          }
          echo "</div>";
          echo "<div class='usuario_posts_informacion'>";
          echo "<p> $objeto->mensaje </p>";
          if ($objeto->archivo_adjunto !== NULL) {
            echo "<img style='width: 100%;'   src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
          }
          echo "</div>";
          echo "</div>";
        }
        unset($_SESSION["posts_usuario_distinto_encontrado"]);
        unset($_SESSION["likes_usuario_post"]);
      } else {
        echo "<div class='usuario_posts'>";
        echo "<p class='usuario_posts_conteo '> Total de posts de este usuario: 0 </p>";
        echo "</div>";
      }
      unset($_SESSION["usuario_distinto_encontrado_exito"]);
    } else if (isset($_SESSION["usuario_distinto_encontrado_error"])) {
      echo "<p class='usuario_parrafo_error_usuario_encontrado '> " . $_SESSION["usuario_distinto_encontrado_error"] .  "</p>";
      unset($_SESSION["usuario_distinto_encontrado_error"]);
    } else {
      echo "<p class='usuario_parrafo_redireccion'> <a href='" . CHILD_ROOT_PATH . "main/home'> Volver a la pagina principal </a> </p>";
    }
    ?>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>