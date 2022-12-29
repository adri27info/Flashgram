<header class="cabecera_main">
  <div class="cabecera_main_centro_superior">
    <img src="<?= CHILD_ROOT_PATH ?>recursos/assets/images/logo.png" id="logo" />
  </div>
  <div class="cabecera_main_centro_inferior">
    <div class="cabecera_main_centro_inferior_enlaces_izquierda">
      <div class="cabecera_main_centro_inferior_enlaces_izquierda_home">
        <span class="material-symbols-outlined">
          home
        </span>
        <a href="<?= CHILD_ROOT_PATH ?>main/home">Inicio</a>
      </div>
      <div class="cabecera_main_centro_inferior_enlaces_izquierda_gente">
        <span class="material-symbols-outlined">
          groups
        </span>
        <a href="<?= CHILD_ROOT_PATH ?>main/usuarios">Usuarios</a>
      </div>
    </div>
    <div class="cabecera_main_centro_inferior_buscar">
      <form action="<?= CHILD_ROOT_PATH ?>main/usuarios" method="post">
        <input type="text" name="usuario" id="usuario" placeholder="Introduce el usuario">
        <input type="hidden" name="buscar_usuario">
        <button type="submit" value="Enviar" name="btnBuscarUsuario">
          <span class="material-symbols-outlined">
            search
          </span>
        </button>
      </form>
    </div>
    <div class="cabecera_main_centro_inferior_enlaces_derecha">
      <div class="cabecera_main_centro_inferior_enlaces_derecha_mensajes">
        <span class="material-symbols-outlined">
          mail
        </span>
        <a href="<?= CHILD_ROOT_PATH ?>mensajes/index">Mensajes privados</a>
      </div>
      <div class="cabecera_main_centro_inferior_enlaces_derecha_notificaciones">
        <?php
        if (isset($_SESSION["notificaciones_no_leidas"])) {
          echo "<span class='material-symbols-outlined notificaciones'> notifications </span>";
        } else {
          echo "<span class='material-symbols-outlined'> notifications </span>";
        }
        ?>
        <a href="<?= CHILD_ROOT_PATH ?>main/notificaciones">Notificaciones</a>
      </div>
    </div>
    <div class="cabecera_main_centro_inferior_opciones">
      <div class="dropdown">
        <div class="dropbtn">
          <?php
          echo "<img src='data:image/" . $_SESSION["usuario_logueado"]->tipo_imagen . ";base64," . base64_encode($_SESSION["usuario_logueado"]->imagen) . "' alt='user-photo-db'>";
          ?>
          <span class="texto_usuario"><?= $_SESSION["usuario"] ?></span>
          <span class="material-symbols-outlined" id="btnOpciones">
            expand_more
          </span>
        </div>
        <div class="dropdown-content" id="dropdown_contenido">
          <div class="dropdown-content-perfil">
            <span class="material-symbols-outlined">
              person
            </span>
            <?php
            echo "<a href='" . CHILD_ROOT_PATH . "usuario/index/?correo=" . $_SESSION["usuario_logueado"]->correo . "'>Perfil</a>";
            ?>
          </div>
          <div class="dropdown-content-datos">
            <span class="material-symbols-outlined">
              settings
            </span>
            <a href="<?= CHILD_ROOT_PATH ?>main/datos">Modificar datos</a>
          </div>
          <div class="dropdown-content-sesion">
            <span class="material-symbols-outlined">
              logout
            </span>
            <a href="<?= CHILD_ROOT_PATH ?>main/sesion">Cerrar sesion</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<span class="material-symbols-outlined boton_subir" id="boton_subir">
  arrow_upward
</span>