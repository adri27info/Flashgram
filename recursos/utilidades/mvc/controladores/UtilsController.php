<?php

class UtilsController
{

  //VALIDACIONES GENERALES
  static function validacionesAcceso($rolUsuario)
  {
    self::validacionesSesion();
    self::validacionesRolUsuario($rolUsuario);
    self::validacionesMetodos();
  }

  static function validacionesSesion()
  {
    $validarSesion = true;
    if (count($_SESSION) === 0) {
      header("Location:" . CHILD_ROOT_PATH . "error/errorAcceso");
      exit();
    } else {
      foreach ($_SESSION as $key => $value) {
        if (!isset($_SESSION[$key])) {
          $validarSesion = false;
          break;
        }
      }
      if ($validarSesion === false) {
        header("Location:" . CHILD_ROOT_PATH . "error/errorAcceso");
        exit();
      }
    }
  }

  static function validacionesRolUsuario($rolUsuario)
  {
    if ($_SESSION["rol_usuario"] !== $rolUsuario) {
      header("Location:" . CHILD_ROOT_PATH . "main/sesion");
      exit();
    }
    $modelo = CoreController::getModel();
    $usuario = $modelo->mostrarUsuario($_SESSION["usuario"], "", 1);
    if (!$usuario) {
      header("Location:" . CHILD_ROOT_PATH . "main/sesion");
      exit();
    } else {
      $_SESSION["usuario_logueado"] = $usuario;
    }
  }

  static function validacionesMetodos()
  {
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        self::validacionesGetToken();
        if (!empty($_GET)) {
          if (isset($_GET["correo"])) {
            self::buscarGetUsuario();
          } else if (isset($_GET["email"])) {
            self::estadisticasUsuario();
          }
        }
        break;
      case "POST":
        if (!empty($_POST)) {
          if (isset($_POST["login"])) {
            self::validacionesPostToken();
          } else if (isset($_POST["subir_post"])) {
            self::subirPost();
          } else if (isset($_POST["borrar_post"])) {
            self::borrarPost();
          } else if (isset($_POST["buscar_usuario"])) {
            self::buscarPostUsuarios();
          } else if (isset($_POST["editar_perfil"])) {
            self::editarPerfil();
          } else if (isset($_POST["enviar_mensaje_privado"])) {
            self::enviarMensajePrivado();
          }
        }
        break;
      default:
        break;
    }
  }

  //GET
  static function validacionesGetToken()
  {
    if (time() > $_SESSION["expiracion_token"]) {
      header("Location:" . CHILD_ROOT_PATH . "main/sesion/?token=expiracion");
      exit();
    }
  }

  static function buscarGetUsuario()
  {
    if ($_GET["correo"] != "") {
      $modelo = CoreController::getModel();
      $postsPropios = $modelo->mostrarPostsUsuario($_GET["correo"]);
      if ($_SESSION["usuario"] === $_GET["correo"]) {
        $_SESSION["usuario_logueado_encontrado"] = true;
        $_SESSION["posts_usuario_logueado_encontrado"] = $postsPropios;
      } else {
        $buscarUsuario = $modelo->mostrarUsuario($_GET["correo"], "", 1);
        if ($buscarUsuario) {
          $_SESSION["usuario_distinto_encontrado_exito"] = $buscarUsuario;
          $_SESSION["posts_usuario_distinto_encontrado"] = $postsPropios;
          $followers = $modelo->mostrarFollowers($_SESSION["usuario"], $_SESSION["id_usuario"]);
          $followings = $modelo->mostrarFollowings($_SESSION["usuario"], $_SESSION["id_usuario"]);
          $_SESSION["likes_usuario_post"] = $modelo->comprobarUsuarioLikePost();
          foreach ($followers as $key => $objeto) {
            if ($objeto->correo === $_GET["correo"]) {
              $_SESSION["follower"] = "Te sigue";
              break;
            }
          }
          foreach ($followings as $key => $objeto) {
            if ($objeto->correo === $_GET["correo"]) {
              $_SESSION["following"] = "Dejar de seguir";
              break;
            }
          }
        } else {
          $_SESSION["usuario_distinto_encontrado_error"] = "El usuario " . $_GET["correo"] . " no se encontro";
        }
      }
    } else {
      return;
    }
  }

  static function estadisticasUsuario()
  {
    if ($_GET["email"] != "") {
      $modelo = CoreController::getModel();
      $buscarUsuario = $modelo->mostrarUsuario($_GET["email"], "", 1);
      if ($buscarUsuario) {
        $followers = $modelo->mostrarFollowers($buscarUsuario->correo, $buscarUsuario->id_usuario);
        $followings = $modelo->mostrarFollowings($buscarUsuario->correo, $buscarUsuario->id_usuario);
        $postsPropios = $modelo->mostrarPostsUsuario($buscarUsuario->correo);
        $postsLikesDados = $modelo->mostrarLikesUsuarioCorreo($buscarUsuario->correo);
        $usuariosPropietariosPostLikes = [];
        foreach ($postsLikesDados as $key => $objeto) {
          array_push($usuariosPropietariosPostLikes, $modelo->mostrarUsuarioMensaje($objeto->id_post));
        }
        if ($followings && count($followings) > 0) {
          $_SESSION["followings"] = $followings;
        } else {
          $_SESSION["followings"] = 0;
        }
        if ($followers && count($followers) > 0) {
          $_SESSION["followers"] = $followers;
        } else {
          $_SESSION["followers"] = 0;
        }
        if ($postsPropios && count($postsPropios) > 0) {
          $_SESSION["posts_propios"] = $postsPropios;
        } else {
          $_SESSION["posts_propios"] = 0;
        }
        if ($postsLikesDados && count($postsLikesDados) > 0) {
          $_SESSION["posts_likes_dados"] = $postsLikesDados;
          $_SESSION["usuarios_likes_dados"] = $usuariosPropietariosPostLikes;
        } else {
          $_SESSION["posts_likes_dados"] = 0;
        }
        if (isset($_SESSION["followers"]) && isset($_SESSION["followers"]) && isset($_SESSION["followers"]) && isset($_SESSION["followers"])) {
          $_SESSION["usuario_email"] = $_GET["email"];
        }
      } else {
        $_SESSION["usuario_email_no_encontrado"] = "El usuario " . $_GET["email"] . " no ha sido encontrado, <a href='" . CHILD_ROOT_PATH . "main/home'> volver a la pagina principal </a>";
      }
    } else {
      return;
    }
  }

  //POST
  static function validacionesPostToken()
  {
    if (isset($_POST["token"])) {
      if ($_POST["token"] !== $_SESSION["token"]) {
        header("Location:" . CHILD_ROOT_PATH . "main/sesion/?token=hackeado");
        exit();
      }
      if ($_POST["token"] === $_SESSION["token"]) {
        if (time() > $_SESSION["expiracion_token"]) {
          header("Location:" . CHILD_ROOT_PATH . "main/sesion/?token=expiracion");
          exit();
        }
      }
    }
  }

  static function buscarPostUsuarios()
  {
    if ($_POST["usuario"] != "") {
      $modelo = CoreController::getModel();
      $usuario = strtolower($_POST["usuario"]);
      $buscarUsuario = $modelo->mostrarUsuarioBuscado($usuario);
      if ($buscarUsuario) {
        $_SESSION["usuario_encontrado_exito"] = $buscarUsuario;
      } else {
        $_SESSION["usuario_encontrado_error"] = "El usuario $usuario no se encontro";
      }
    } else {
      return;
    }
  }

  static function enviarMensajePrivado()
  {
    $modelo = CoreController::getModel();
    $array = explode("_", $_POST["selector"]);
    $idUsuarioConversacion = $array[1];
    $mensaje = $_POST["contenido"];
    $fecha = date("Y-m-d");
    if ($_FILES["imagen"]["name"] != "") {
      $nombreImagen = $_FILES["imagen"]["name"];
      $tipoImagen = explode("/", $_FILES["imagen"]["type"])[1];
      $sizeImagen = $_FILES["imagen"]["size"];
      $nombreImagenTemporal = $_FILES["imagen"]["tmp_name"];
      if ($tipoImagen === "jpeg" || $tipoImagen === "jpg" || $tipoImagen === "png" || $tipoImagen === "gif") {
        $imagenSubida = fopen($nombreImagenTemporal, "r");
        $contenidoImagen = fread($imagenSubida, $sizeImagen);
        fclose($imagenSubida);
      } else {
        $_SESSION["conversacion_usuario_imagen_error"] = "Error al enviar el mensaje, el tipo $tipoImagen de la imagen no esta permitido";
        return;
      }
      $conversacionUsuario = $modelo->registrarConversacionUsuario(0, $_SESSION["id_usuario"], $idUsuarioConversacion, $fecha, $mensaje, $contenidoImagen, $tipoImagen);
      if ($conversacionUsuario === 0) {
        $_SESSION["conversacion_usuario_error"] = "Error, el mensaje no se pudo enviar";
      } else {
        $notificacion = $modelo->registrarNotificacion(0, 3);
        $id_notificacion = $modelo->mostrarUltimaNotificacionInsertada()->id_notificacion;
        $notificacionUsuario = $modelo->registrarNotificacionUsuario($id_notificacion, $_SESSION["id_usuario"], date("Y-m-d"), $idUsuarioConversacion, "No leida");
        $_SESSION["conversacion_usuario_exito"] = "Exito, el mensaje se pudo enviar correctamente";
      }
    } else {
      $conversacionUsuario = $modelo->registrarConversacionUsuario(0, $_SESSION["id_usuario"], $idUsuarioConversacion, $fecha, $mensaje, NULL, NULL);
      if ($conversacionUsuario === 0) {
        $_SESSION["conversacion_usuario_error"] = "Error, el mensaje no se pudo enviar";
      } else {
        $notificacion = $modelo->registrarNotificacion(0, 3);
        $id_notificacion = $modelo->mostrarUltimaNotificacionInsertada()->id_notificacion;
        $notificacionUsuario = $modelo->registrarNotificacionUsuario($id_notificacion, $_SESSION["id_usuario"], date("Y-m-d"), $idUsuarioConversacion, "No leida");
        $_SESSION["conversacion_usuario_exito"] = "Exito, el mensaje se pudo enviar correctamente";
      }
    }
  }

  static function borrarPost()
  {
    if ($_POST["id_post"] != "") {
      $modelo = CoreController::getModel();
      $idPost = $_POST["id_post"];
      $usuariosLikesPost = $modelo->mostrarUsuariosLikesPost($idPost);
      if ($usuariosLikesPost && count($usuariosLikesPost) > 0) {
        foreach ($usuariosLikesPost as $key => $objeto) {
          $updateLikeUsuario = $modelo->actualizarLikeUsuario($objeto->correo, "-");
        }
      }
      $borrarPost = $modelo->borrarPost($idPost);
      if ($borrarPost != 0) {
        $updatePostUsuario = $modelo->actualizarPostUsuario($_SESSION["usuario"], "-");
        $_SESSION["usuario_logueado"]->posts_cantidad = $_SESSION["usuario_logueado"]->posts_cantidad - 1;
        $_SESSION["post_borrado_exito"] = "Exito, el post se ha borrado correctamente";
      } else {
        $_SESSION["post_borrado_error"] = "Error, el post no se pudo borrar";
      }
    } else {
      return;
    }
  }

  static function subirPost()
  {
    $tipoImagen = NULL;
    $contenidoImagen = NULL;
    if ($_POST["mensaje"] != "") {
      $mensaje = $_POST["mensaje"];
    } else {
      $mensaje = "";
    }
    if ($_FILES["imagen"]["name"] != "") {
      $nombreImagen = $_FILES["imagen"]["name"];
      $tipoImagen = explode("/", $_FILES["imagen"]["type"])[1];
      $sizeImagen = $_FILES["imagen"]["size"];
      $nombreImagenTemporal = $_FILES["imagen"]["tmp_name"];
      if ($tipoImagen === "jpeg" || $tipoImagen === "jpg" || $tipoImagen === "png" || $tipoImagen === "gif") {
        $imagenSubida = fopen($nombreImagenTemporal, "r");
        $contenidoImagen = fread($imagenSubida, $sizeImagen);
        fclose($imagenSubida);
      } else {
        $_SESSION["post_subido_imagen_error_tipo"] = "Error al ingresar el post, el tipo $tipoImagen no esta permitido";
        return;
      }
    }
    $modelo = CoreController::getModel();
    $post = $modelo->registrarPost(0, $mensaje, $contenidoImagen, $tipoImagen);
    $registroPostUsuario = $modelo->registrarPostUsuario($modelo->mostrarUltimoPostInsertado()->id_post, $_SESSION["id_usuario"], date("Y-m-d"));
    if ($post === 0) {
      $_SESSION["post_subido_imagen_error_insertar"] = "Error, el post no se pudo insertar";
    } else {
      if ($registroPostUsuario === 0) {
        $_SESSION["post_subido_imagen_error_registrar"] = "Error, el post no se pudo insertar, ni registrar";
      } else {
        $updatePostUsuario = $modelo->actualizarPostUsuario($_SESSION["usuario"], "+");
        $_SESSION["usuario_logueado"]->posts_cantidad = $_SESSION["usuario_logueado"]->posts_cantidad + 1;
        $_SESSION["post_subido_imagen_exito"] = "Exito, el post se ha subido correctamente";
      }
    }
  }

  static function editarPerfil()
  {
    $modelo = CoreController::getModel();
    if ($_FILES["imagen"]["name"] != "") {
      $nombreImagen = $_FILES["imagen"]["name"];
      $tipoImagen = explode("/", $_FILES["imagen"]["type"])[1];
      $sizeImagen = $_FILES["imagen"]["size"];
      $nombreImagenTemporal = $_FILES["imagen"]["tmp_name"];
      if ($tipoImagen === "jpeg" || $tipoImagen === "jpg" || $tipoImagen === "png" || $tipoImagen === "gif") {
        $imagenSubida = fopen($nombreImagenTemporal, "r");
        $contenidoImagen = fread($imagenSubida, $sizeImagen);
        fclose($imagenSubida);
      } else {
        $_SESSION["editar_perfil_imagen_tipo_error"] = "Error al editar el perfil, el tipo $tipoImagen de la imagen no esta permitido";
        return;
      }
      $updateUsuario = $modelo->actualizarDatosUsuario($_SESSION["usuario"], $_POST["nombre"], $_POST["biografia"], $contenidoImagen, $tipoImagen, 5);
      if ($updateUsuario != 0) {
        $_SESSION["usuario_logueado"]->imagen = $contenidoImagen;
        $_SESSION["usuario_logueado"]->tipo_imagen = $tipoImagen;
        $_SESSION["editar_perfil_exito"] = "Exito, el perfil se actualizo correctamente";
      } else {
        $_SESSION["editar_perfil_error"] = "Error, el perfil no se actualizo correctamente";
      }
    } else {
      $updateUsuario = $modelo->actualizarDatosUsuario($_SESSION["usuario"], $_POST["nombre"], $_POST["biografia"], "", "", 3);
      if ($updateUsuario != 0) {
        $_SESSION["editar_perfil_exito"] = "Exito, el perfil se actualizo correctamente";
      } else {
        $_SESSION["editar_perfil_error"] = "Error, el perfil no se actualizo correctamente";
      }
    }
  }
}