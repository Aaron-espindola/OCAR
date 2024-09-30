<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shotcut icon" href="img/icon2.webp">
    <link rel="stylesheet" href="estilos/axa.scss?v=<?php echo filemtime('estilos/axa.scss'); ?>">
    <title>Registrarse</title>
</head>

<body>

    <video muted autoplay loop style ="position: absolute;">
        <source src="img/ten_1.mp4" type="video/mp4">
    </video>

    <div class="page">
      <div class="container">

        <div class="right">
          <div id="form_registro">
        
            <form action="php/db_registro.php" method="POST" id="form_r">
              <label for="name"> Nombre: </label>
                <input required name="name" type="text" id="name">
              
              <label for="lastName"> Apellido: </label>
                <input required name="lastName" type="text" id="lastName">

              <label for="email"> Correo electrónico: </label>
                <input required name="email" type="email" id="email" onchange="validarEmail()">
              
              <label for="confEmail"> Confirmar correo electrónico: </label>
                <input required name="confEmail" type="email" id="confEmail" onchange="compararEmails()">

              <label for="password"> Contraseña: </label>
                <input required type="password" name="pass" id="contrasenia" onchange="validarContrasenia()">
              
              <label for="confPass"> Confirmar Contraseña: </label>
                <input required type="password"  id="confContra" onchange="compararContrasenias()">
             
                <input type="submit" value="Registrarme" class="btnF btnF-white btnF-animated">
            </form>
          </div>
        </div>

        <div class="left">

          <div class="titulo">
            Register
          </div>
          <div class="eula">
            Bienvenido a O_CAR. <br> <br>
            Registrate para poder administrar, de la forma más sencilla, todo lo que ocurra en tu taller.
          </div>
        </div>

      </div>
    </div>

  <script src= "js/script_ocar.js"></script>
</body>
</html>