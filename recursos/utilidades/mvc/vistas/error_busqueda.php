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
</head>

<body>
  <section class="error_pagina">
    <div class="error_pagina_logo">
      <img src="<?= CHILD_ROOT_PATH ?>recursos/assets/images/logo.png" alt=" Flashgram">
    </div>
    <p class="error_pagina_parrafo">Error, la pagina que has introducido no existe </p>
    <a class="error_pagina_enlace" href="<?= CHILD_ROOT_PATH ?>auth/login">Volver a la pagina principal</a>
  </section>
  <?php include("componentes/footer.php"); ?>
</body>

</html>