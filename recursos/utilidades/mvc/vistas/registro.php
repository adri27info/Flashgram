<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashgram</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="<?= CHILD_ROOT_PATH ?>recursos/assets/css/estilos.css" />
  <link rel="shortcut icon" href="<?= CHILD_ROOT_PATH ?>recursos/assets/images/favicon.ico" type="image/x-icon" />
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/registro.js" defer type="module"></script>
</head>

<body id="body">
  <?php include("componentes/header_auth.php"); ?>
  <form action="<?= CHILD_ROOT_PATH ?>auth/login" method="post" class="formulario_registro" id="formulario_registro">
    <h2>Registrarse</h2>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" placeholder="Introduce tu nombre" id="nombre" maxlength="30">
    <div class="contenedor_nombre_validacion ocultar" id="contenedor_nombre_validacion">
      <span class="material-symbols-outlined"> person </span>
      <span id="error_nombre_validacion" class="error_nombre_validacion">Error [-3, +30]. Debes
        introducir entre 3 y 30 caracteres</span>
    </div>
    <label for="correo">Correo</label>
    <input type="text" name="correo" placeholder="Introduce tu correo" id="correo" maxlength="50">
    <div class="contenedor_correo_validacion ocultar" id="contenedor_correo_validacion">
      <span class="material-symbols-outlined"> email </span>
      <span id="error_correo_validacion" class="error_correo_validacion">Error, debes introducir un correo que sea
        valido</span>
    </div>
    <label for="nombre">Password</label>
    <input type="password" name="password" placeholder="Introduce tu contraseña" id="password">
    <div class="contenedor_password_validacion ocultar" id="contenedor_password_validacion">
      <span class="material-symbols-outlined"> key </span>
      <span id="error_password_validacion" class="error_password_validacion">Error [-4, +20]. Debes
        introducir entre 4 y 20 caracteres</span>
    </div>
    <input type="submit" name="btnRegistro" value="Enviar" id="btnRegistro">
  </form>
  <?php include("componentes/footer.php"); ?>
</body>

</html>