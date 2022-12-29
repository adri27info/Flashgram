<?php

require_once(CONTROLLER_PATH . "CoreController.php");
require_once(CONTROLLER_PATH . "UtilsController.php");
require_once(CONTROLLER_PATH . "AuthController.php");
require_once(CONTROLLER_PATH . "MainController.php");
require_once(CONTROLLER_PATH . "ErrorController.php");
require_once(CONTROLLER_PATH . "UsuarioController.php");
require_once(CONTROLLER_PATH . "EstadisticasController.php");
require_once(CONTROLLER_PATH . "MensajesController.php");

class Router
{
  private $controlador;
  private $metodo;

  public function __construct()
  {
    $this->metodosRouter();
  }

  public function metodosRouter()
  {
    //Esta aplicacion esta basada en rutas como esta -> controlador/metodo_defecto o controlador/metodo_controlador
    $url = explode("/", URL_ROUTER);
    //Si no se pasa controlador, el controlador por defecto sera Auth
    $this->controlador = empty($url[1]) ? "AuthController" : $url[1] . "Controller";
    //Si no se pasa metodo, el metodo por defecto sera login
    $this->metodo = empty($url[2]) ? "login" : $url[2];
  }

  public function ejecutar()
  {
    if (class_exists($this->controlador)) {
      $controlador = new $this->controlador();
      $metodo  = $this->metodo;
      if (method_exists($this->controlador, $metodo)) {
        if (isset($_GET["token"])) {
          $controlador->$metodo($_GET["token"]);
        } else if (isset($_GET["partida_error"])) {
          $controlador->$metodo($_GET["partida_error"]);
        } else if (isset($_GET["datos"])) {
          $controlador->$metodo($_GET["datos"]);
        } else {
          $controlador->$metodo();
        }
      } else {
        ErrorController::errorBusqueda();
      }
    } else {
      ErrorController::errorBusqueda();
    }
    $modelo = CoreController::getModel();
    $modelo->closeConnection();
  }
}