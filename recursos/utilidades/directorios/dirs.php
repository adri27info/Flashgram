<?php
/* ------------ RUTAS ABSOLUTAS ------------ */
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] .  "/apps/php/Flashgram/");
define('CONNECTION_PATH', ROOT_PATH . 'recursos/utilidades/conectividad/class/');
define('MODEL_PATH', ROOT_PATH . 'recursos/utilidades/mvc/modelos/');
define('VIEW_PATH', ROOT_PATH . 'recursos/utilidades/mvc/vistas/');
define('CONTROLLER_PATH', ROOT_PATH . 'recursos/utilidades/mvc/controladores/');
define('ROUTER_PATH', ROOT_PATH . 'recursos/utilidades/enrutador/');
define('CSS_PATH', ROOT_PATH . 'recursos/assets/css/');
define('IMAGES_PATH', ROOT_PATH . 'recursos/assets/images/');
define('JS_PATH', ROOT_PATH . 'recursos/assets/js/');
/* ------------ RUTAS RELATIVAS ------------ */
define('CHILD_ROOT_PATH', "/apps/php/Flashgram/");
define('URL_ROUTER', substr($_SERVER["REQUEST_URI"], strlen(dirname($_SERVER["SCRIPT_NAME"]))));