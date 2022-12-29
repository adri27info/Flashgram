<?php

class MensajesController
{
  static function index()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $usuarios = $modelo->mostrarUsuarios();
    require_once(VIEW_PATH . "mensajes.php");
  }

  static function enviados()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $conversaciones = $modelo->mostrarConversacionesUsuarioEnviadas($_SESSION["usuario"]);
    if ($conversaciones && count($conversaciones) > 0) {
      $_SESSION["conversaciones_enviadas"] = $conversaciones;
      $_SESSION["usuarios_conversaciones_enviadas"] = [];
      foreach ($conversaciones as $key => $objeto) {
        array_push($_SESSION["usuarios_conversaciones_enviadas"], $modelo->mostrarUsuarioConversacion($objeto->id_usuario_conversacion));
      }
    }
    require_once(VIEW_PATH . "mensajes_enviados.php");
  }

  static function recibidos()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $conversaciones = $modelo->mostrarConversacionesUsuarioRecibidas($_SESSION["id_usuario"], $_SESSION["usuario"]);
    if ($conversaciones && count($conversaciones) > 0) {
      $_SESSION["conversaciones_recibidas"] = $conversaciones;
      $_SESSION["usuarios_conversaciones_recibidas"] = [];
      foreach ($conversaciones as $key => $objeto) {
        array_push($_SESSION["usuarios_conversaciones_recibidas"], $modelo->mostrarUsuarioConversacion($objeto->id_usuario_conversacion));
      }
    }
    require_once(VIEW_PATH . "mensajes_recibidos.php");
  }
}