<?php

session_start();
include_once("../../directorios/dirs.php");
include_once(MODEL_PATH . "UserModel.php");
header('Content-Type: application/json; charset=utf-8');

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        operacionesUsuario();
        break;
    default:
        break;
}

function operacionesUsuario()
{
    $modelo = new UserModel();
    $data = json_decode(file_get_contents('php://input'), true);
    if (count($data) === 4) {
        if ($data["nombre"] !== "" && $data["correo"] !== "" && $data["password"] !== "" && $data["metodo"] !== "") {
            if ($data["metodo"] === "registrar") {
                $usuarioRegistrar = $modelo->mostrarUsuario($data["correo"], md5($data["password"]), 1);
                if ($usuarioRegistrar) {
                    codigoRespuestaApi(200);
                    echo json_encode(array("error" => "Error, el usuario ya existe"));
                } else {
                    //La imagen que se guarda en la BBDD por defecto es de tipo png y esta almacenada en los assets.
                    $imagenDefault =  IMAGES_PATH . "user-default.png";
                    $tipoImagen = pathinfo($imagenDefault, PATHINFO_EXTENSION);
                    $gestor = fopen($imagenDefault, "r");
                    $contenido = fread($gestor, filesize($imagenDefault));
                    fclose($gestor);
                    $usuarioRegistrado = $modelo->registrarUsuario(
                        0,
                        $data["nombre"],
                        "Esta es mi biografia",
                        $contenido,
                        $tipoImagen,
                        $data["correo"],
                        md5($data["password"]),
                        date("Y-m-d"),
                        0,
                        0,
                        0,
                        0,
                        2
                    );
                    if ($usuarioRegistrado === 0) {
                        codigoRespuestaApi(200);
                        echo json_encode(array("error" => "Error, el usuario no se ha podido registrar correctamente"));
                    } else {
                        codigoRespuestaApi(200);
                        echo json_encode(array("exito" => "Usuario registrado correctamente, volviendo a la pagina principal ..."));
                    }
                }
            }
        }
    } else if (count($data) === 3) {
        if ($data["correo"] !== "" && $data["password"] !== "" && $data["metodo"] !== "") {
            if ($data["metodo"] === "mostrar") {
                $usuarioMostrar = $modelo->mostrarUsuario($data["correo"], md5($data["password"]), 2);
                if ($usuarioMostrar) {
                    $_SESSION["usuario"] = $data["correo"];
                    $usuarioMostrar->id_rol === "1" ? $_SESSION["rol_usuario"] = "admin" : $_SESSION["rol_usuario"] = "usuario";
                    $_SESSION["id_usuario"] = $usuarioMostrar->id_usuario;
                    $_SESSION["token"] = bin2hex(random_bytes(32));
                    $_SESSION["expiracion_token"] = time() + 60 * 120; // 2h desde ahora - expiracion del token
                    codigoRespuestaApi(200);
                    echo json_encode(array("exito" => "Iniciando sesion...", "token" => $_SESSION["token"], "rol" => $_SESSION["rol_usuario"]));
                } else {
                    codigoRespuestaApi(200);
                    echo json_encode(array("error" => "Error, datos erroneos"));
                }
            }
        }
    } else {
        codigoRespuestaApi(404);
        echo json_encode(array("error_comprobacion" => "Error, al comprobar el correo introducido"));
    }
}


function codigoRespuestaApi($codigo)
{
    return http_response_code($codigo);
}