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
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/usuarios.js" defer type="module"></script>
</head>

<body id="body">
  <?php include("componentes/header_main.php"); ?>
  <section class="usuarios" id="usuarios">
    <h1 class="usuarios_titulo">Usuarios</h1>
    <?php
    if (isset($_SESSION["usuario_encontrado_exito"])) {
      echo "<span class='usuarios_total'>Total de usuarios - " . count($_SESSION["usuario_encontrado_exito"]) . "</span>";
      echo "<hr class='usuarios_separador'>";
      foreach ($_SESSION["usuario_encontrado_exito"] as $key => $objeto) {
        echo "<div class='usuarios_informacion'>";
        echo "<div class='usuarios_informacion_datos'>";
        echo "<img class='usuarios_informacion_datos_imagen' src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo'>";
        echo "<span class='usuarios_informacion_datos_nombre'> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . "'> " . $objeto->nombre . "</a>" . " - " . $objeto->correo . "</span>";
        echo "</div>";
        if ($objeto->correo !== $_SESSION["usuario"]) {
          echo "<div class='usuarios_informacion_follows'>";
          echo "<div class='usuarios_informacion_follow_contenedor' id='usuarios_informacion_follows_contenedor_" . $_SESSION["id_usuario"] . "-" . $objeto->id_usuario . "'>";
          $usuarioSeguido = $modelo->mostrarUsuarioSeguido($_SESSION["id_usuario"], $objeto->id_usuario);
          if ($usuarioSeguido) {
            echo "<span class='material-symbols-outlined usuarios_informacion_follow_contenedor_boton no_seguir'>block</span>";
            echo "<span class='usuarios_informacion_follow_contenedor_texto'>Dejar de seguir</span>";
          } else {
            echo "<span class='material-symbols-outlined usuarios_informacion_follow_contenedor_boton seguir'>arrow_right_alt</span>";
            echo "<span class='usuarios_informacion_follow_contenedor_texto'>Seguir</span>";
          }
          echo "</div>";
          echo "</div>";
        }
        echo "</div>";
        echo count($usuarios) != ($key + 1) ? "<hr class='usuarios_separador'>" : "";
      }
      unset($_SESSION["usuario_encontrado_exito"]);
      return;
    } else if (isset($_SESSION["usuario_encontrado_error"])) {
      echo "<span class='usuario_encontrado'>" . $_SESSION["usuario_encontrado_error"] . "</span>";
      unset($_SESSION["usuario_encontrado_error"]);
      return;
    }
    if ($usuarios && count($usuarios) > 0) {
      echo "<span class='usuarios_total'>Total de usuarios - " . count($usuarios) . "</span>";
      echo "<hr class='usuarios_separador'>";
      foreach ($usuarios as $key => $objeto) {
        echo "<div class='usuarios_informacion'>";
        echo "<div class='usuarios_informacion_datos'>";
        echo "<img class='usuarios_informacion_datos_imagen' src='data:image/" . $objeto->tipo_imagen . ";base64," . base64_encode($objeto->imagen) . "' alt='user-photo'>";
        echo "<span class='usuarios_informacion_datos_nombre'> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $objeto->correo . "'> " . $objeto->nombre . "</a>" . " - " . $objeto->correo . "</span>";
        echo "</div>";
        if ($objeto->correo !== $_SESSION["usuario"]) {
          echo "<div class='usuarios_informacion_follows'>";
          echo "<div class='usuarios_informacion_follow_contenedor' id='usuarios_informacion_follows_contenedor_" . $_SESSION["id_usuario"] . "-" . $objeto->id_usuario . "'>";
          $usuarioSeguido = $modelo->mostrarUsuarioSeguido($_SESSION["id_usuario"], $objeto->id_usuario);
          if ($usuarioSeguido) {
            echo "<span class='material-symbols-outlined usuarios_informacion_follow_contenedor_boton no_seguir'>block</span>";
            echo "<span class='usuarios_informacion_follow_contenedor_texto'>Dejar de seguir</span>";
          } else {
            echo "<span class='material-symbols-outlined usuarios_informacion_follow_contenedor_boton seguir'>arrow_right_alt</span>";
            echo "<span class='usuarios_informacion_follow_contenedor_texto'>Seguir</span>";
          }
          echo "</div>";
          echo "</div>";
        }
        echo "</div>";
        echo count($usuarios) != ($key + 1) ? "<hr class='usuarios_separador'>" : "";
      }
    } else {
      echo "<span class='usuarios_total'>Total de usuarios - " . count($usuarios) . "</span>";
    }
    ?>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>