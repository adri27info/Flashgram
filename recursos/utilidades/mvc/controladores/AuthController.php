<?php

class AuthController
{
  static function login()
  {
    if (isset($_SESSION["usuario"])) {
      header("Location:" . CHILD_ROOT_PATH . "main/home");
      exit();
    }
    if (!empty($_GET) && isset($_GET["token"])) {
      if ($_GET["token"] === "expiracion") {
        $parrafoToken = "<p class='parrafoToken'> El token ha expirado, vuelva a iniciar sesión</p>";
      } else if ($_GET["token"] === "hackeado") {
        $parrafoToken = "<p class='parrafoToken'> El token se ha intentado hackear, por lo cual se ha cerrado la sesión</p>";
      }
    }
    require_once(VIEW_PATH . "login.php");
  }

  static function registro()
  {
    require_once(VIEW_PATH . "registro.php");
  }
}