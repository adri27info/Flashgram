<?php

class MainController
{
  static function home()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $obtenerLikesUsuarioPost = $modelo->comprobarUsuarioLikePost();
    $posts = $modelo->mostrarPosts();
    $notificaciones = $modelo->mostrarNotificaciones($_SESSION["id_usuario"]);
    foreach ($notificaciones as $key => $objeto) {
      if ($objeto->estado_notificacion === "No leida") {
        $_SESSION["notificaciones_no_leidas"] = true;
      }
    }
    require_once(VIEW_PATH . "home.php");
  }

  static function usuarios()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $usuarios = $modelo->mostrarUsuarios();
    require_once(VIEW_PATH . "usuarios.php");
  }

  static function mensajes()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    require_once(VIEW_PATH . "mensajes.php");
  }

  static function notificaciones()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $notificaciones = $modelo->mostrarNotificaciones($_SESSION["id_usuario"]);
    if ($notificaciones && count($notificaciones) > 0) {
      $_SESSION["notificaciones"] = $notificaciones;
      $_SESSION["nombres_notificadores"] = [];
      foreach ($notificaciones as $key => $objeto) {
        $modelo->actualizarEstadoNotificacion($objeto->id_notificacion, "Leida");
        array_push($_SESSION["nombres_notificadores"], $modelo->mostrarUsuariosNotificaciones($objeto->id_notificacion));
      }
      unset($_SESSION["notificaciones_no_leidas"]);
    }
    require_once(VIEW_PATH . "notificaciones.php");
  }

  static function datos()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    require_once(VIEW_PATH . "datos.php");
  }

  static function sesion()
  {
    session_destroy();
    if (isset($_GET["token"])) {
      if ($_GET["token"] === "expiracion") {
        header("Location:" . CHILD_ROOT_PATH . "auth/login/?token=" . $_GET["token"]);
        exit();
      } else if ($_GET["token"] === "hackeado") {
        header("Location:" . CHILD_ROOT_PATH . "auth/login/?token=" . $_GET["token"]);
        exit();
      }
    } else {
      header("Location:" . CHILD_ROOT_PATH . "auth/login");
      exit();
    }
  }
}