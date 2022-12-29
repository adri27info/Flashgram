<?php

class ErrorController
{
  static function errorAcceso()
  {
    require_once(VIEW_PATH . "error_acceso.php");
  }

  static function errorBusqueda()
  {
    require_once(VIEW_PATH . "error_busqueda.php");
  }
}