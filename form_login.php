<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img\icon2.webp" type="image/x-icon">
    <link rel="stylesheet" href="estilos/axa.scss?v=<?php echo filemtime('estilos/axa.scss'); ?>">
    <script src="https://kit.fontawesome.com/48e0e5e260.js" crossorigin="anonymous"></script>
    <title>Iniciar sesion</title>
</head>

<body>

    <video muted autoplay loop style ="position: absolute;">
        <source src="img/ten_1.mp4" type="video/webm">
    </video>

    <div class="page">
    <div class="container">

      <div class="left">
        <div class="titulo">
          Login
        </div>
        <div class="eula">
          Bienvenido de nuevo al sistema organizador de clientes, autos y reparaciones.
        </div>
      </div>

      <div class="right">
        <div class="form_inicio">
        
          <form action="php/db_logIn.php" method="POST" id="form_login">
              <label for="email">Email:</label>
                <i class="fa-regular fa-envelope"></i>
                  <input type="email" name="mail">
                    <div class="linea">
                      <svg viewBox="0 0 320 300">
                        <defs>
                          <linearGradient
                            inkscape:collect="always"
                            id="linearGradient"
                            x1="13"
                            y1="193.49992"
                            x2="307"
                            y2="193.49992"
                            gradientUnits="userSpaceOnUse">
                              <stop
                                style="stop-color:#1d0799;"
                                offset="0"
                                id="stop876" />
                              <stop
                                style="stop-color:#00bfff;"
                                offset="1"
                                id="stop878" />
                          </linearGradient>
                        </defs>
                        <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
                      </svg>
                    </div>
              <label for="password">Contraseña:</label>
                <i class="fa-solid fa-lock"></i>
                  <input type="password" name="pass">
                    <div class="linea">
                      <svg viewBox="0 0 320 300">
                        <defs>
                          <linearGradient
                            inkscape:collect="always"
                            id="linearGradient"
                            x1="13"
                            y1="193.49992"
                            x2="307"
                            y2="193.49992"
                            gradientUnits="userSpaceOnUse">
                              <stop
                                style="stop-color:#00bbfff;"
                                offset="0"
                                id="stop876" />
                              <stop
                                style="stop-color:#1d0799;"
                                offset="1"
                                id="stop878" />
                          </linearGradient>
                        </defs>
                          <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
                      </svg>
                    </div>
                  <input type="submit" value="Iniciar Sesion" class="btnF btnF-white btnF-animated">
                  <div  role="alert">
                  <?php 
                  if (isset($_GET['message'])) {
                    switch ($_GET['message']) {
                      case 'error_pass':
                        echo 'Error, Contraseña incorrecta';
                        break;
                      case 'error_user':
                        echo 'Error, el Email no coincide con algun usuario.';
                        break;
                      case 'recoveryOK':
                          echo 'Inicia sesión con tu nueva contraseña';
                        break;    
                      default:
                        echo '';
                        break;
                    }
                  }        
                  ?>
                </div>
          </form>
            <a href="recup_contra.php" id="fg_pass">¿Olvidaste tu contraseña?</a>
        </div>
      </div>
    </div>
  </div>


</body>
</html>