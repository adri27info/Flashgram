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
  <section class="notificaciones">
    <h1 class="notificaciones_titulo">Notificaciones</h1>
    <?php
    if (isset($_SESSION["notificaciones"])) {
      echo "<div class='notificaciones_datos'>";
      foreach ($_SESSION["nombres_notificadores"] as $key => $objeto) {
        echo "<div class='notificaciones_datos_textos'>";
        if ($_SESSION["notificaciones"][$key]->categoria === "like") {
          echo "<span class='material-symbols-outlined'> notifications </span>";
          echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["nombres_notificadores"][$key][0]->correo . "'>" .   $_SESSION["nombres_notificadores"][$key][0]->nombre . "</a> le hado like a uno de tus posts en la fecha: " . $_SESSION["notificaciones"][$key]->fecha_notificacion  .  "</span>";
        } else if ($_SESSION["notificaciones"][$key]->categoria === "follow") {
          echo "<span class='material-symbols-outlined'> notifications </span>";
          echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["nombres_notificadores"][$key][0]->correo . "'>" .   $_SESSION["nombres_notificadores"][$key][0]->nombre . "</a>  te dio follow en la fecha: " . $_SESSION["notificaciones"][$key]->fecha_notificacion  .  "</span>";
        } else if ($_SESSION["notificaciones"][$key]->categoria === "mensaje_privado") {
          echo "<span class='material-symbols-outlined'> notifications </span>";
          echo "<span> <a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["nombres_notificadores"][$key][0]->correo . "'>" .   $_SESSION["nombres_notificadores"][$key][0]->nombre . "</a>  te escribio un mensaje privado en la fecha: " . $_SESSION["notificaciones"][$key]->fecha_notificacion  .  "</span>";
        }
        echo "</div>";
      }
      echo "</div>";
      unset($_SESSION["notificaciones"]);
      unset($_SESSION["nombres_notificadores"]);
    } else {
      echo "<p class='notificaciones_parrafo'> Actualmente este usuario no tiene notificacioness</p>";
    }
    ?>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>