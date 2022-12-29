<?php

include_once(CONNECTION_PATH . "conexion.php");

class UserModel
{

  /* -------------- SELECT -------------- */
  function mostrarUsuario($correo, $password, $numParametros = 0)
  {
    $sql = "";
    if ($numParametros === 1) {
      $sql = "SELECT * FROM usuarios where correo = :correo";
    } else if ($numParametros === 2) {
      $sql = "SELECT * FROM usuarios where correo = :correo and password = :password";
    }
    try {
      $conex = BD::crearConexion()->prepare($sql);
      $conex->bindParam(':correo', $correo);
      if ($numParametros === 2) $conex->bindParam(':password', $password);
      $conex->execute();
      $usuario = $conex->fetch();
      return $usuario;
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la busqueda del usuario");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuarios()
  {
    try {
      $conex = BD::crearConexion()->query("select * from usuarios");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los usuarios registrados");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuarioSeguido($id_usuario, $id_usuario_seguido)
  {
    try {
      $conex = BD::crearConexion()->query("select * from usuarios_followers where id_usuario = $id_usuario and id_usuario_seguido =  $id_usuario_seguido");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los usuarios seguidos");
    } finally {
      $conex = null;
    }
  }

  function mostrarUltimoPostInsertado()
  {
    try {
      $conex = BD::crearConexion()->query("select id_post from posts order by id_post desc limit 1");
      return $conex->fetch();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar el ultimo post insertado");
    } finally {
      $conex = null;
    }
  }

  function mostrarUltimoLikeInsertado()
  {
    try {
      $conex = BD::crearConexion()->query("select id_like from likes order by id_like desc limit 1");
      return $conex->fetch();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar el ultimo like insertado");
    } finally {
      $conex = null;
    }
  }


  function mostrarUltimaNotificacionInsertada()
  {
    try {
      $conex = BD::crearConexion()->query("select id_notificacion from notificaciones order by id_notificacion desc limit 1");
      return $conex->fetch();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar la ultima notificacion insertada");
    } finally {
      $conex = null;
    }
  }

  function mostrarPosts()
  {
    try {
      $conex = BD::crearConexion()->query("select up.fecha_post, u.id_usuario, u.imagen, u.tipo_imagen, u.nombre, u.correo, p.id_post,
      p.mensaje, p.archivo_adjunto, p.tipo_archivo from usuarios_posts up
      inner join usuarios u on up.id_usuario = u.id_usuario
      inner join posts p on up.id_post = p.id_post");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los posts");
    } finally {
      $conex = null;
    }
  }

  function mostrarPostsUsuario($usuario)
  {
    try {
      $conex = BD::crearConexion()->query("select up.fecha_post, u.id_usuario, u.imagen, u.tipo_imagen, u.nombre, u.correo, p.id_post,
      p.mensaje, p.archivo_adjunto, p.tipo_archivo from usuarios_posts up
      inner join usuarios u on up.id_usuario = u.id_usuario inner join posts
      p on up.id_post = p.id_post where u.correo = '$usuario'");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los posts del usuario $usuario");
    } finally {
      $conex = null;
    }
  }

  function comprobarUsuarioLikePost()
  {
    try {
      $conex = BD::crearConexion()->query("select u.id_usuario, p.id_post, l.id_like from posts p
      inner join likes l on p.id_post = l.id_post
      inner join usuarios_likes ul on ul.id_like = l.id_like
      inner join usuarios u on u.id_usuario = ul.id_usuario");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los likes del post por parte del usuario");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuariosLikesPost($id_post)
  {
    try {
      $conex = BD::crearConexion()->query("select u.correo from posts p 
      inner join likes l on p.id_post = l.id_post
      inner join usuarios_likes ul on ul.id_like = l.id_like
      inner join usuarios u on u.id_usuario = ul.id_usuario
      where l.id_post = $id_post;");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los usuarios que le han dado like al post $id_post");
    } finally {
      $conex = null;
    }
  }

  function mostrarLikesUsuarioCorreo($correo)
  {
    try {
      $conex = BD::crearConexion()->query("select p.id_post, p.mensaje, p.archivo_adjunto, p.tipo_archivo, uf.fecha_post,
      u.nombre, u.correo, u.imagen, u.tipo_imagen from posts p
      inner join likes l on p.id_post = l.id_post
      inner join usuarios_likes ul on ul.id_like = l.id_like
      inner join usuarios u on u.id_usuario = ul.id_usuario
      inner join usuarios_posts uf on p.id_post = uf.id_post 
      where u.correo = '$correo'");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los posts que le ha dado like al usuario $correo");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuarioMensaje($idPost)
  {
    try {
      $conex = BD::crearConexion()->query("select u.nombre, u.correo, u.imagen, u.tipo_imagen from usuarios u
      inner join usuarios_posts up on up.id_usuario = u.id_usuario
      inner join posts p on p.id_post = up.id_post
      where p.id_post = $idPost");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los posts con el id $idPost");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuarioBuscado($nombre)
  {
    try {
      $conex = BD::crearConexion()->query("select * from usuarios where nombre = '$nombre' or correo = '$nombre'");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar el usuario $nombre");
    } finally {
      $conex = null;
    }
  }

  function mostrarFollowers($correo, $idPropio)
  {
    try {
      $conex = BD::crearConexion()->query("select u.correo, u.nombre, u.imagen, u.tipo_imagen from usuarios u 
      inner join usuarios_followers uf on u.id_usuario = uf.id_usuario where u.correo != '$correo' and uf.id_usuario_seguido = $idPropio");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los followers del usuario $correo");
    } finally {
      $conex = null;
    }
  }

  function mostrarFollowings($correo, $idPropio)
  {
    try {
      $conex = BD::crearConexion()->query("select u.correo, u.nombre, u.imagen, u.tipo_imagen from usuarios u
       inner join usuarios_followers uf on u.id_usuario = uf.id_usuario_seguido
      where u.correo != '$correo' and uf.id_usuario = $idPropio");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar los followings del usuario $correo");
    } finally {
      $conex = null;
    }
  }

  function mostrarConversacionesUsuarioEnviadas($correo)
  {
    try {
      $conex = BD::crearConexion()->query("select u.nombre, u.imagen, u.tipo_imagen, u.correo, ufm.id_usuario, ufm.id_usuario_conversacion,
      ufm.fecha_mensaje_transmitido, ufm.mensaje_transmitido, ufm.imagen as imagen_ufm, ufm.tipo_imagen as tipo_imagen_ufm from usuarios u 
      inner join usuarios_followers_mensajes ufm on ufm.id_usuario = u.id_usuario
      where u.correo = '$correo'");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar las conversaciones enviadas del usuario $correo");
    } finally {
      $conex = null;
    }
  }

  function mostrarConversacionesUsuarioRecibidas($idPropio, $correo)
  {
    try {
      $conex = BD::crearConexion()->query("select u.nombre, u.imagen, u.tipo_imagen, u.correo, ufm.id_usuario, ufm.id_usuario_conversacion,
      ufm.fecha_mensaje_transmitido, ufm.mensaje_transmitido, ufm.imagen as imagen_ufm, ufm.tipo_imagen as tipo_imagen_ufm from usuarios u 
      inner join usuarios_followers_mensajes ufm on ufm.id_usuario = u.id_usuario
      where ufm.id_usuario_conversacion = $idPropio");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar las conversaciones recibidas del usuario $correo");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuarioConversacion($id_usuario)
  {
    try {
      $conex = BD::crearConexion()->query("select * from usuarios where id_usuario = $id_usuario");
      return $conex->fetch();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar el usuario de la conversacion");
    } finally {
      $conex = null;
    }
  }

  function mostrarNotificaciones($id_usuario)
  {
    try {
      $conex = BD::crearConexion()->query("select u.nombre, u.correo, un.fecha_notificacion, un.estado_notificacion, c.nombre as categoria, n.id_notificacion from usuarios u
      inner join usuarios_notificaciones un on un.id_usuario_notificado = u.id_usuario
      inner join notificaciones n on n.id_notificacion = un.id_notificacion
      inner join categorias c on c.id_categoria = n.id_categoria
      where un.id_usuario_notificado = $id_usuario");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar las notificaciones del usuario con el id $id_usuario");
    } finally {
      $conex = null;
    }
  }

  function mostrarUsuariosNotificaciones($id_notificacion)
  {
    try {
      $conex = BD::crearConexion()->query("select u.nombre, u.correo, un.id_notificacion from usuarios u
      inner join usuarios_notificaciones un on un.id_usuario = u.id_usuario
      where un.id_notificacion = $id_notificacion");
      return $conex->fetchAll();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al mostrar el nombre del notificador con el id $id_notificacion");
    } finally {
      $conex = null;
    }
  }

  /* -------------- INSERT -------------- */
  function registrarUsuario(
    $id_usuario,
    $nombre,
    $biografia,
    $imagen,
    $tipo_imagen,
    $correo,
    $password,
    $fecha_registro,
    $followers_cantidad,
    $following_cantidad,
    $posts_cantidad,
    $likes_cantidad,
    $id_rol
  ) {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO usuarios VALUES (:id_usuario, :nombre, :biografia, :imagen,
      :tipo_imagen, :correo, :password, :fecha_registro, :followers_cantidad, :following_cantidad, :posts_cantidad,
      :likes_cantidad, :id_rol)");
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':nombre', $nombre);
      $conex->bindParam(':biografia', $biografia);
      $conex->bindParam(':imagen', $imagen);
      $conex->bindParam(':tipo_imagen', $tipo_imagen);
      $conex->bindParam(':correo', $correo);
      $conex->bindParam(':password', $password);
      $conex->bindParam(':fecha_registro', $fecha_registro);
      $conex->bindParam(':followers_cantidad', $followers_cantidad);
      $conex->bindParam(':following_cantidad', $following_cantidad);
      $conex->bindParam(':posts_cantidad', $posts_cantidad);
      $conex->bindParam(':likes_cantidad', $likes_cantidad);
      $conex->bindParam(':id_rol', $id_rol);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la insercion del usuario");
    } finally {
      $conex = null;
    }
  }

  function registrarFollowUsuario($id_usuario, $id_usuario_seguido, $fecha_seguimiento)
  {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO usuarios_followers VALUES (:id_usuario, :id_usuario_seguido, :fecha_seguimiento)");
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':id_usuario_seguido', $id_usuario_seguido);
      $conex->bindParam(':fecha_seguimiento', $fecha_seguimiento);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar el follow al usuario seguido");
    } finally {
      $conex = null;
    }
  }

  function registrarLike($id_like, $id_post)
  {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO likes VALUES (:id_like, :id_post)");
      $conex->bindParam(':id_like', $id_like);
      $conex->bindParam(':id_post', $id_post);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar el like");
    } finally {
      $conex = null;
    }
  }

  function registrarPost(
    $id_post,
    $mensaje,
    $archivo_adjunto,
    $tipo_archivo
  ) {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO posts VALUES (:id_post, :mensaje, :archivo_adjunto, :tipo_archivo)");
      $conex->bindParam(':id_post', $id_post);
      $conex->bindParam(':mensaje', $mensaje);
      $conex->bindParam(':archivo_adjunto', $archivo_adjunto);
      $conex->bindParam(':tipo_archivo', $tipo_archivo);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar el post");
    } finally {
      $conex = null;
    }
  }

  function registrarPostUsuario($id_post, $id_usuario, $fecha_post)
  {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO usuarios_posts VALUES (:id_post, :id_usuario, :fecha_post)");
      $conex->bindParam(':id_post', $id_post);
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':fecha_post', $fecha_post);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar el post del usuario");
    } finally {
      $conex = null;
    }
  }

  function registrarLikeUsuario($id_like, $id_usuario, $fecha_like)
  {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO usuarios_likes VALUES (:id_like, :id_usuario, :fecha_like)");
      $conex->bindParam(':id_like', $id_like);
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':fecha_like', $fecha_like);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar el like del post del usuario");
    } finally {
      $conex = null;
    }
  }

  function registrarNotificacion($id_notificacion, $tipo_notificacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO notificaciones VALUES (:id_notificacion, :tipo_notificacion)");
      $conex->bindParam(':id_notificacion', $id_notificacion);
      $conex->bindParam(':tipo_notificacion', $tipo_notificacion);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar la notificacion");
    } finally {
      $conex = null;
    }
  }

  function registrarNotificacionUsuario($id_notificacion, $id_usuario, $fecha_notificacion, $id_usuario_notificado, $estado_notificacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO usuarios_notificaciones VALUES (:id_notificacion,
      :id_usuario, :fecha_notificacion, :id_usuario_notificado, :estado_notificacion)");
      $conex->bindParam(':id_notificacion', $id_notificacion);
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':fecha_notificacion', $fecha_notificacion);
      $conex->bindParam(':id_usuario_notificado', $id_usuario_notificado);
      $conex->bindParam(':estado_notificacion', $estado_notificacion);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar la notificacion del usuario");
    } finally {
      $conex = null;
    }
  }

  function registrarConversacionUsuario(
    $id_usuario_follow_conversacion_key = 0,
    $id_usuario,
    $id_usuario_conversacion,
    $fecha_mensaje_transmitido,
    $mensaje_transmitido,
    $imagen,
    $tipo_imagen
  ) {
    try {
      $conex = BD::crearConexion()->prepare("INSERT INTO usuarios_followers_mensajes VALUES 
      (:id_usuario_follow_conversacion_key, :id_usuario, :id_usuario_conversacion,
      :fecha_mensaje_transmitido, :mensaje_transmitido, :imagen, :tipo_imagen)");
      $conex->bindParam(':id_usuario_follow_conversacion_key', $id_usuario_follow_conversacion_key);
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':id_usuario_conversacion', $id_usuario_conversacion);
      $conex->bindParam(':fecha_mensaje_transmitido', $fecha_mensaje_transmitido);
      $conex->bindParam(':mensaje_transmitido', $mensaje_transmitido);
      $conex->bindParam(':imagen', $imagen);
      $conex->bindParam(':tipo_imagen', $tipo_imagen);
      return $conex->execute();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al insertar la conversacion del usuario");
    } finally {
      $conex = null;
    }
  }

  /* -------------- UPDATE -------------- */
  function actualizarPostUsuario($correo, $operacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("update usuarios set posts_cantidad = (posts_cantidad $operacion 1) where correo = :correo");
      $conex->bindParam(':correo', $correo);
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la actualizacion del post del usuario");
    } finally {
      $conex = null;
    }
  }

  function actualizarFollowingUsuario($correo, $operacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("update usuarios set following_cantidad = (following_cantidad $operacion 1) where correo = :correo");
      $conex->bindParam(':correo', $correo);
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la actualizacion del following del usuario");
    } finally {
      $conex = null;
    }
  }

  function actualizarFollowersUsuario($id_usuario, $operacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("update usuarios set followers_cantidad = (followers_cantidad $operacion 1) where id_usuario = :id_usuario");
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la actualizacion del follower del usuario");
    } finally {
      $conex = null;
    }
  }

  function actualizarLikeUsuario($correo, $operacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("update usuarios set likes_cantidad = (likes_cantidad $operacion 1) where correo = :correo");
      $conex->bindParam(':correo', $correo);
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la actualizacion del like del usuario");
    } finally {
      $conex = null;
    }
  }

  function actualizarDatosUsuario($correo, $nombre, $biografia, $imagen, $tipoImagen, $numParametros)
  {
    try {
      $sql = "";
      if ($numParametros === 3) {
        $sql = "update usuarios set nombre = ?,  biografia = ? where correo = ?";
        $conex = BD::crearConexion()->prepare($sql);
        $conex->execute([$nombre, $biografia, $correo]);
        return $conex->rowCount();
      } else if ($numParametros === 5) {
        $sql = "update usuarios set nombre = ?,  biografia = ?, imagen = ?, tipo_imagen = ? where correo = ?";
        $conex = BD::crearConexion()->prepare($sql);
        $conex->execute([$nombre, $biografia, $imagen, $tipoImagen, $correo]);
        return $conex->rowCount();
      }
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la actualizacion de los datos del usuario");
    } finally {
      $conex = null;
    }
  }

  function actualizarEstadoNotificacion($id_notificacion, $estado_notificacion)
  {
    try {
      $conex = BD::crearConexion()->prepare("update usuarios_notificaciones set estado_notificacion = ? where id_notificacion = ?");
      $conex->execute([$estado_notificacion, $id_notificacion]);
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar la actualizacion del estado de la notificacion");
    } finally {
      $conex = null;
    }
  }

  /* -------------- DELETE -------------- */
  function borrarFollowUsuario($id_usuario, $id_usuario_seguido)
  {
    try {
      $conex = BD::crearConexion()->prepare("delete from usuarios_followers where id_usuario = :id_usuario and id_usuario_seguido = :id_usuario_seguido");
      $conex->bindParam(':id_usuario', $id_usuario);
      $conex->bindParam(':id_usuario_seguido', $id_usuario_seguido);
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar el unfollow del usuario seguido");
    } finally {
      $conex = null;
    }
  }

  function borrarLikeUsuario($id_usuario, $id_post)
  {
    try {
      $conex = BD::crearConexion()->prepare("delete likes.* from likes inner join usuarios_likes on usuarios_likes.id_like = likes.id_like
      inner join posts on posts.id_post = likes.id_post where usuarios_likes.id_usuario = $id_usuario and posts.id_post = $id_post; ");
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar el unlike del usuario seguido");
    } finally {
      $conex = null;
    }
  }

  function borrarPost($id_post)
  {
    try {
      $conex = BD::crearConexion()->prepare("delete from posts where id_post = :id_post");
      $conex->bindParam(':id_post', $id_post);
      $conex->execute();
      return $conex->rowCount();
    } catch (PDOException $exception) {
      echo $exception->getMessage();
      die("[-] Error, al realizar el borrado del post");
    } finally {
      $conex = null;
    }
  }

  function closeConnection()
  {
    BD::cerrarConexion();
  }
}