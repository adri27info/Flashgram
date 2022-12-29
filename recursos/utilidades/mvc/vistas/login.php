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
  <script src="<?= CHILD_ROOT_PATH ?>recursos/assets/js/login.js" defer type="module"></script>
</head>

<body id="body">
  <?php include("componentes/header_auth.php"); ?>
  <form action="<?= CHILD_ROOT_PATH ?>main/home" method="POST" class="formulario_login" id="formulario_login">
    <h2>Identificarse</h2>
    <label for="correo">Correo</label>
    <input type="text" name="correo" placeholder="Introduce tu correo" id="correo">
    <div class="contenedor_correo_validacion ocultar" id="contenedor_correo_validacion">
      <span class="material-symbols-outlined"> email </span>
      <span id="error_correo_validacion" class="error_correo_validacion">Error, correo invalido</span>
    </div>
    <label for="nombre">Password</label>
    <input type="password" name="password" placeholder="Introduce tu contraseña" id="password">
    <div class="contenedor_password_validacion ocultar" id="contenedor_password_validacion">
      <span class="material-symbols-outlined"> key </span>
      <span id="error_password_validacion" class="error_password_validacion">Error, password invalida</span>
    </div>
    <input type="hidden" name="token" id="token">
    <input type="hidden" name="login">
    <input type="submit" name="btnLogin" value="Enviar" id="btnLogin">
  </form>
  <?php if (isset($parrafoToken)) echo $parrafoToken; ?>
  <?php include("componentes/footer.php"); ?>
</body>

</html>