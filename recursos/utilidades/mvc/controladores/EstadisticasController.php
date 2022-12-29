<?php

class EstadisticasController
{
  static function index()
  {
    $modelo = CoreController::getModel();
    UtilsController::validacionesAcceso("usuario");
    $followers = $modelo->mostrarFollowers($_SESSION["usuario"], $_SESSION["id_usuario"]);
    $followings = $modelo->mostrarFollowings($_SESSION["usuario"], $_SESSION["id_usuario"]);
    $postsPropios = $modelo->mostrarPostsUsuario($_SESSION["usuario"]);
    $postsLikesDados = $modelo->mostrarLikesUsuarioCorreo($_SESSION["usuario"]);
    $usuariosPropietariosPostLikes = [];
    foreach ($postsLikesDados as $key => $objeto) {
      array_push($usuariosPropietariosPostLikes, $modelo->mostrarUsuarioMensaje($objeto->id_post));
    }
    require_once(VIEW_PATH . "estadisticas.php");
  }
}