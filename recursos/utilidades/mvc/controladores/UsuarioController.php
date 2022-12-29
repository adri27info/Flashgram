<?php

class UsuarioController
{
  static function index()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    require_once(VIEW_PATH . "usuario.php");
  }
}