<?php

session_start();
include_once("../../directorios/dirs.php");
include_once(MODEL_PATH . "UserModel.php");
header('Content-Type: application/json; charset=utf-8');

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    interaccionesUsuario();
    break;
  default:
    break;
}

function interaccionesUsuario()
{
  $modelo = new UserModel();
  $data = json_decode(file_get_contents('php://input'), true);
  if (count($data) === 4) {
    if ($data["id_usuario"] !== "" && $data["id_usuario_seguido"] !== "" && $data["metodo"] !== "" && $data["acto"] !== "") {
      if ($data["acto"] === "operacion_follow") {
        if ($data["metodo"] === "follow") {
          $usuarioFollow = $modelo->registrarFollowUsuario($data["id_usuario"], $data["id_usuario_seguido"], date("Y-m-d"));
          if ($usuarioFollow === 0) {
            codigoRespuestaApi(200);
            echo json_encode(array("error" => "Error, el follow no se pudo realizar"));
          } else {
            $actualizarFollowingUsuario = $modelo->actualizarFollowingUsuario($_SESSION["usuario"], "+");
            $actualizarFollowerUsuarioSeguido = $modelo->actualizarFollowersUsuario($data["id_usuario_seguido"], "+");
            $notificacion = $modelo->registrarNotificacion(0, 2);
            $id_notificacion = $modelo->mostrarUltimaNotificacionInsertada()->id_notificacion;
            $notificacionUsuario = $modelo->registrarNotificacionUsuario($id_notificacion, $_SESSION["id_usuario"], date("Y-m-d"), $data["id_usuario_seguido"], "No leida");
            codigoRespuestaApi(200);
            echo json_encode(array("exito" => "El follow, se realizo correctamente", "follow" => "->"));
          }
        } else if ($data["metodo"] === "unfollow") {
          $usuarioUnfollow = $modelo->borrarFollowUsuario($data["id_usuario"], $data["id_usuario_seguido"]);
          if ($usuarioUnfollow != 0) {
            $actualizarFollowingUsuario = $modelo->actualizarFollowingUsuario($_SESSION["usuario"], "-");
            $actualizarFollowerUsuarioSeguido = $modelo->actualizarFollowersUsuario($data["id_usuario_seguido"], "-");
            codigoRespuestaApi(200);
            echo json_encode(array("exito" => "El unfollow, se realizo correctamente", "unfollow" => "<-"));
          } else {
            codigoRespuestaApi(200);
            echo json_encode(array("error" => "Error, el unfollow no se realizo correctamente"));
          }
        }
      }
    }
  } else if (count($data) === 6) {
    if ($data["id_like"] !== "" && $data["id_post"] !== "" && $data["id_usuario"] !== "" && $data["metodo"] !== "" && $data["acto"] !== "" && $data["id_usuario_like"]) {
      if ($data["acto"] === "operacion_like") {
        if ($data["metodo"] === "like") {
          $usuarioLike = $modelo->registrarLike($data["id_like"], $data["id_post"]);
          $usuarioRegistroLike = $modelo->registrarLikeUsuario($modelo->mostrarUltimoLikeInsertado()->id_like, $data["id_usuario"], date("Y-m-d"));
          if ($usuarioLike === 0 || $usuarioRegistroLike === 0) {
            codigoRespuestaApi(200);
            echo json_encode(array("error" => "Error, el like no se pudo realizar"));
          } else {
            $actualizarLikesUsuario = $modelo->actualizarLikeUsuario($_SESSION["usuario"], "+");
            $notificacion = $modelo->registrarNotificacion(0, 1);
            $id_notificacion = $modelo->mostrarUltimaNotificacionInsertada()->id_notificacion;
            $notificacionUsuario = $modelo->registrarNotificacionUsuario($id_notificacion, $_SESSION["id_usuario"], date("Y-m-d"), $data["id_usuario_like"], "No leida");
            codigoRespuestaApi(200);
            echo json_encode(array("exito" => "El like, se realizo correctamente", "like" => "+"));
          }
        } else if ($data["metodo"] === "unlike") {
          $borrarLikeUsuario = $modelo->borrarLikeUsuario($data["id_usuario"], $data["id_post"]);
          if ($borrarLikeUsuario != 0) {
            $actualizarLikesUsuario = $modelo->actualizarLikeUsuario($_SESSION["usuario"], "-");
            codigoRespuestaApi(200);
            echo json_encode(array("exito" => "El unlike, se realizo correctamente", "unlike" => "-"));
          } else {
            codigoRespuestaApi(200);
            echo json_encode(array("error" => "Error el unlike no se realizo correctamente"));
          }
        }
      }
    }
  } else {
    codigoRespuestaApi(404);
    echo json_encode(array("error_comprobacion" => "Error al realizar las interacciones del usuario"));
  }
}

function codigoRespuestaApi($codigo)
{
  return http_response_code($codigo);
}