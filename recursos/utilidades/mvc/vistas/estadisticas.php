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
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/main.js" defer></script>
</head>

<body id="body">
  <?php include("componentes/header_main.php"); ?>
  <section class="estadisticas">
    <?php
    if (isset($_SESSION["usuario_email_no_encontrado"])) {
      echo "<p class='estadisticas_usuario_error'> " . $_SESSION["usuario_email_no_encontrado"] . "</p>";
      unset($_SESSION["usuario_email_no_encontrado"]);
    } else if (isset($_SESSION["usuario_email"])) {
    ?>
    <div class="estadisticas_following">
      <?php
        if ($_SESSION["followings"] && count($_SESSION["followings"]) > 0) {
          echo "<h1 class='estadisticas_following_titulo'> Followings - " . $_SESSION["usuario_email"]  . "</h1>";
          echo "<span class='estadisticas_following_total'>Total de usuarios - " . count($_SESSION["followings"]) . "</span>";
          echo "<hr class='estadisticas_following_separador'>";
          foreach ($_SESSION["followings"] as $key => $objeto) {
            echo "<div class='estadisticas_following_datos'>";
            echo " <img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
            echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . "'> " . $objeto->nombre . "</a>" . " - " . $objeto->correo . "</span>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_following_titulo'> Followings - " . $_SESSION["usuario_email"] . "</h1>";
          echo "<span class='estadisticas_following_total'>Total de usuarios - 0 </span>";
          echo "<hr class='estadisticas_following_separador'>";
        }
        ?>
    </div>
    <div class="estadisticas_followers">
      <?php
        if ($_SESSION["followers"] && count($_SESSION["followers"]) > 0) {
          echo "<h1 class='estadisticas_followers_titulo'> Followers - " . $_SESSION["usuario_email"]  . "</h1>";
          echo "<span class='estadisticas_followers_total'>Total de usuarios - " . count($_SESSION["followers"]) . "</span>";
          echo "<hr class='estadisticas_followers_separador'>";
          foreach ($_SESSION["followers"] as $key => $objeto) {
            echo "<div class='estadisticas_followers_datos'>";
            echo " <img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
            echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . "'> " . $objeto->nombre . "</a>" . " - " . $objeto->correo . "</span>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_followers_titulo'> Followers - " . $_SESSION["usuario_email"] . "</h1>";
          echo "<span class='estadisticas_followers_total'>Total de usuarios - 0 </span>";
          echo "<hr class='estadisticas_followers_separador'>";
        }
        ?>
    </div>
    <div class="estadisticas_posts">
      <?php
        if ($_SESSION["posts_propios"] && count($_SESSION["posts_propios"]) > 0) {
          echo "<h1 class='estadisticas_posts_titulo'> Post - " . $_SESSION['usuario_email']  . "</h1>";
          echo "<span class='estadisticas_posts_total'>Total de posts - " . count($_SESSION["posts_propios"]) . "</span>";
          echo "<hr class='estadisticas_posts_separador'>";
          foreach ($_SESSION["posts_propios"] as $key => $objeto) {
            echo "<div class='estadisticas_posts_datos'>";
            echo "<div classs='estadisticas_posts_datos_imagen' style='background-color: silver; width: 100%; display: flex; flex-flow: column nowrap; justify-content: center; align-items: center;'> ";
            echo "<div class='estadisticas_posts_datos_imagen_data'>";
            echo "<img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
            echo "</div>";
            echo "</div>";
            echo "<div class='estadisticas_posts_datos_usuario'>";
            echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . ">" . $objeto->nombre . "</a>";
            echo "<span>" . $objeto->correo . "</span>";
            echo "<span>" . $objeto->fecha_post .  "</span>";
            echo "</div>";
            echo "<div class='estadisticas_posts_datos_informacion'>";
            echo "<p> $objeto->mensaje </p>";
            if ($objeto->archivo_adjunto !== NULL) {
              echo "<img style='width: 100%;' src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
            }
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_posts_titulo'> Post - " . $_SESSION['usuario_email']  . "</h1>";
          echo "<span class='estadisticas_posts_total'>Total de posts - 0</span>";
          echo "<hr class='estadisticas_posts_separador'>";
        }
        ?>
    </div>
    <div class="estadisticas_likes">
      <?php
        if ($_SESSION["posts_likes_dados"] && count($_SESSION["posts_likes_dados"]) > 0) {
          echo "<h1 class='estadisticas_likes_titulo'> Likes - " . $_SESSION['usuario_email']  . "</h1>";
          echo "<span class='estadisticas_likes_total'>Total de likes dados - " . count($_SESSION["posts_likes_dados"]) . "</span>";
          echo "<hr class='estadisticas_likes_separador'>";
          foreach ($_SESSION["posts_likes_dados"] as $key => $objeto) {
            echo "<div class='estadisticas_likes_datos'>";
            echo "<div classs='estadisticas_likes_datos_imagen' style='background-color: silver; width: 100%; display: flex; flex-flow: column nowrap; justify-content: center; align-items: center;'> ";
            echo "<div class='estadisticas_likes_datos_imagen_data'>";
            echo "<img src='data:image/" . $_SESSION["usuarios_likes_dados"][$key][0]->tipo_imagen . ";base64," . base64_encode($_SESSION["usuarios_likes_dados"][$key][0]->imagen) . "' alt='user-photo-db-profile'>";
            echo "</div>";
            echo "</div>";
            echo "<div class='estadisticas_likes_datos_usuario'>";
            echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["usuarios_likes_dados"][$key][0]->correo . ">" . $_SESSION["usuarios_likes_dados"][$key][0]->nombre . "</a>";
            echo "<span>" . $_SESSION["usuarios_likes_dados"][$key][0]->correo . "</span>";
            echo "<span>" . $objeto->fecha_post .  "</span>";
            echo "</div>";
            echo "<div class='estadisticas_likes_datos_informacion'>";
            echo "<p> $objeto->mensaje </p>";
            if ($objeto->archivo_adjunto !== NULL) {
              echo "<img style='width: 100%;' src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
            }
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_likes_titulo'> Likes - " . $_SESSION['usuario_email']  . "</h1>";
          echo "<span class='estadisticas_likes_total'>Total de likes dados - 0</span>";
          echo "<hr class='estadisticas_likes_separador'>";
        }
        ?>
    </div>
    <?php
      unset($_SESSION["usuario_email"]);
      unset($_SESSION["followings"]);
      unset($_SESSION["followers"]);
      unset($_SESSION["posts_propios"]);
      unset($_SESSION["posts_likes_dados"]);
      unset($_SESSION["usuarios_likes_dados"]);
    } else {
    ?>
    <div class="estadisticas_following">
      <?php
        if ($followings && count($followings) > 0) {
          echo "<h1 class='estadisticas_following_titulo'> Followings - " . $_SESSION["usuario"]  . "</h1>";
          echo "<span class='estadisticas_following_total'>Total de usuarios - " . count($followings) . "</span>";
          echo "<hr class='estadisticas_following_separador'>";
          foreach ($followings as $key => $objeto) {
            echo "<div class='estadisticas_following_datos'>";
            echo " <img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
            echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . "'> " . $objeto->nombre . "</a>" . " - " . $objeto->correo . "</span>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_following_titulo'> Followings - " . $_SESSION["usuario"] . "</h1>";
          echo "<span class='estadisticas_following_total'>Total de usuarios - " . count($followings) . "</span>";
          echo "<hr class='estadisticas_following_separador'>";
        }
        ?>
    </div>
    <div class="estadisticas_followers">
      <?php
        if ($followers && count($followers) > 0) {
          echo "<h1 class='estadisticas_followers_titulo'> Followers - " . $_SESSION["usuario"]  . "</h1>";
          echo "<span class='estadisticas_followers_total'>Total de usuarios - " . count($followers) . "</span>";
          echo "<hr class='estadisticas_followers_separador'>";
          foreach ($followers as $key => $objeto) {
            echo "<div class='estadisticas_followers_datos'>";
            echo " <img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
            echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . "'> " . $objeto->nombre . "</a>" . " - " . $objeto->correo . "</span>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_followers_titulo'> Followers - " . $_SESSION["usuario"] . "</h1>";
          echo "<span class='estadisticas_followers_total'>Total de usuarios - " . count($followers) . "</span>";
          echo "<hr class='estadisticas_followers_separador'>";
        }
        ?>
    </div>
    <div class="estadisticas_posts">
      <?php
        if ($postsPropios && count($postsPropios) > 0) {
          echo "<h1 class='estadisticas_posts_titulo'> Post - " . $_SESSION['usuario']  . "</h1>";
          echo "<span class='estadisticas_posts_total'>Total de posts - " . count($postsPropios) . "</span>";
          echo "<hr class='estadisticas_posts_separador'>";
          foreach ($postsPropios as $key => $objeto) {
            echo "<div class='estadisticas_posts_datos'>";
            echo "<div classs='estadisticas_posts_datos_imagen' style='background-color: silver; width: 100%; display: flex; flex-flow: column nowrap; justify-content: center; align-items: center;'> ";
            echo "<div class='estadisticas_posts_datos_imagen_data'>";
            echo "<img src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo-db-profile'>";
            echo "</div>";
            echo "</div>";
            echo "<div class='estadisticas_posts_datos_usuario'>";
            echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . ">" . $objeto->nombre . "</a>";
            echo "<span>" . $objeto->correo . "</span>";
            echo "<span>" . $objeto->fecha_post .  "</span>";
            echo "</div>";
            echo "<div class='estadisticas_posts_datos_informacion'>";
            echo "<p> $objeto->mensaje </p>";
            if ($objeto->archivo_adjunto !== NULL) {
              echo "<img style='width: 100%;' src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
            }
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_posts_titulo'> Post - " . $_SESSION['usuario']  . "</h1>";
          echo "<span class='estadisticas_posts_total'>Total de posts - 0</span>";
          echo "<hr class='estadisticas_posts_separador'>";
        }
        ?>
    </div>
    <div class="estadisticas_likes">
      <?php
        if ($postsLikesDados && count($postsLikesDados) > 0) {
          echo "<h1 class='estadisticas_likes_titulo'> Likes - " . $_SESSION['usuario']  . "</h1>";
          echo "<span class='estadisticas_likes_total'>Total de likes dados - " . count($postsLikesDados) . "</span>";
          echo "<hr class='estadisticas_likes_separador'>";
          foreach ($postsLikesDados as $key => $objeto) {
            echo "<div class='estadisticas_likes_datos'>";
            echo "<div classs='estadisticas_likes_datos_imagen' style='background-color: silver; width: 100%; display: flex; flex-flow: column nowrap; justify-content: center; align-items: center;'> ";
            echo "<div class='estadisticas_likes_datos_imagen_data'>";
            echo "<img src='data:image/" . $usuariosPropietariosPostLikes[$key][0]->tipo_imagen . ";base64," . base64_encode($usuariosPropietariosPostLikes[$key][0]->imagen) . "' alt='user-photo-db-profile'>";
            echo "</div>";
            echo "</div>";
            echo "<div class='estadisticas_likes_datos_usuario'>";
            echo "<a href=" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $usuariosPropietariosPostLikes[$key][0]->correo . ">" . $usuariosPropietariosPostLikes[$key][0]->nombre . "</a>";
            echo "<span>" . $usuariosPropietariosPostLikes[$key][0]->correo . "</span>";
            echo "<span>" . $objeto->fecha_post .  "</span>";
            echo "</div>";
            echo "<div class='estadisticas_likes_datos_informacion'>";
            echo "<p> $objeto->mensaje </p>";
            if ($objeto->archivo_adjunto !== NULL) {
              echo "<img style='width: 100%;' src='data:image/" . $objeto->tipo_archivo . ";base64," . base64_encode($objeto->archivo_adjunto) . "' alt='user-photo-db-post'>";
            }
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<h1 class='estadisticas_likes_titulo'> Likes - " . $_SESSION['usuario']  . "</h1>";
          echo "<span class='estadisticas_likes_total'>Total de likes dados - 0</span>";
          echo "<hr class='estadisticas_likes_separador'>";
        }
        ?>
    </div>
    <?php
    }
    ?>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>